<?php

namespace App\Services;

use App\Exceptions\StoreOrderNotAllowedException;
use App\Exceptions\WalletHasNotEnoughCredit;
use App\Jobs\HandleUnprocessedOrdersJob;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Ratio;
use App\Models\Transaction;
use App\Repository\CurrencyRepositoryInterface;
use App\Repository\Eloquent\TransactionRepository;
use App\Repository\OrderRepositoryInterface;
use App\Repository\RatioRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * @var RatioRepositoryInterface
     */
    private RatioRepositoryInterface $ratioRepository;
    private OrderRepositoryInterface $orderRepository;
    private WalletService $walletService;
    private TransactionService $transactionService;
    private CurrencyRepositoryInterface $currencyRepository;

    public function __construct(
        RatioRepositoryInterface    $ratioRepository,
        OrderRepositoryInterface    $orderRepository,
        CurrencyRepositoryInterface $currencyRepository,
        TransactionRepository       $transactionRepository,

        WalletService               $walletService,
        TransactionService          $transactionService

    )
    {
        $this->ratioRepository = $ratioRepository;
        $this->orderRepository = $orderRepository;

        $this->walletService = $walletService;
        $this->transactionService = $transactionService;
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * @throws StoreOrderNotAllowedException
     * @throws WalletHasNotEnoughCredit
     */
    public function storeNewOrder($data): \Illuminate\Database\Eloquent\Model
    {
        $exchangeable_id = $data['exchangeable_id'];
        $orderAmount = $data['amount'];
        $tradableRatio = $data['tradable_ratio'];
        $orderType = $data['order_type'];
        $userId = 1;

        $dbRatioItem = $this->ratioRepository->getRatiosWithCurrencies($exchangeable_id);

        if ($orderType == 'sell' && $tradableRatio < $dbRatioItem->value) {
            throw new StoreOrderNotAllowedException();
        }
        if ($orderType == 'buy' && $tradableRatio > $dbRatioItem->value) {
            throw new StoreOrderNotAllowedException();
        }

        $currencyId = $dbRatioItem->currencyA->id;
        $this->ensureUserHasEnoughCreditForThisOrder($userId, $currencyId, $orderAmount);

        $data = [
            'user_id' => 1,
            'exchangeable_id' => $exchangeable_id,
            'tradable_ratio' => $tradableRatio,
            'amount' => $orderAmount,
            'type' => $orderType,
        ];

        return $this->orderRepository->create($data);

    }

    public function buy()
    {

    }

    /**
     * @param $userId
     * @param $currencyId
     * @param $orderAmount
     * @return bool
     * @throws WalletHasNotEnoughCredit
     */
    public function ensureUserHasEnoughCreditForThisOrder($userId, $currencyId, $orderAmount): bool
    {
        $userWallet = $this->walletService->getUserWallet($userId, $currencyId);

        if ($userWallet->amount < $orderAmount) {
            throw new WalletHasNotEnoughCredit($userId, $currencyId);
        } else {
            return true;
        }

    }

    public function handleOrders()
    {
        $orders = $this->orderRepository->getUnprocessedOrders();

        /** @var Order $order */
        foreach ($orders as $order) {
            HandleUnprocessedOrdersJob::dispatch($order->toArray());
        }
    }

    /**
     * @throws WalletHasNotEnoughCredit
     */
    public function handleOrder($orderId)
    {
        /** @var Order $order */
        /** @var Ratio $ratio */

        $order = $this->orderRepository->find($orderId);
        $ratio = $this->ratioRepository->find($order->exchangeable_id);


        try {
            DB::beginTransaction();
            if ($order->type == 'sell') {
                $this->handelSellOrder($order, $ratio);
            } elseif ($order->type = 'buy') {
                $this->handelBuyOrder($order, $ratio);
            }
            Db::commit();


        } catch (WalletHasNotEnoughCredit $e) {
            DB::rollBack();

            info("order failed. id: {$order->id}, reason: WalletHasNotEnoughCredit");
            dump("order failed. id: {$order->id}, reason: WalletHasNotEnoughCredit");
            $order->update(['status' => 'failed']);
            $order->save();
        }


    }


    /**
     * transaction to sell(-) Origin currency
     * add origin currency to inventory
     * calculate the value of sell currency
     * transaction to buy(+) Origin currency with calculated value
     *
     */
    private function handelSellOrder(Order $order, Ratio $ratio)
    {

        if ($order->tradable_ratio >= $ratio->value) {

            Transaction::query()->create([
                'order_id' => $order->id,
                'currency_id' => $ratio->currencyB->id,
                'amount' => (-1) * $order->amount,
                'user_id' => $order->user_id,
            ]);

            $inventory = Inventory::query()->lockForUpdate()->find($ratio->currencyB->id);
            $inventory->amount -= $order->amount;
            $inventory->save();


            Transaction::query()->create([
                'order_id' => $order->id,
                'currency_id' => $ratio->currencyA->id,
                'amount' => $order->tradable_ratio,
                'user_id' => $order->user_id,
            ]);

            $inventory = Inventory::query()->lockForUpdate()->find($ratio->currencyA->id);
            $inventory->amount += $order->tradable_ratio;
            $inventory->save();

            $order->update(['status' => 'done']);

        }

    }

    private function handelBuyOrder(Order $order, Ratio $ratio)
    {

        if ($order->tradable_ratio <= $ratio->value) {

            Transaction::query()->create([
                'order_id' => $order->id,
                'currency_id' => $ratio->currencyB->id,
                'amount' => (-1) * $order->amount,
                'user_id' => $order->user_id,
            ]);
            $currencyBWallet = $this->walletService->getUserWallet($order->user_id, $ratio->currencyB->id);
            $currencyBWallet->amount -= $order->amount;
            $currencyBWallet->save();

            // ------------------------------------------------------------------------------------------
            Transaction::query()->create([
                'order_id' => $order->id,
                'currency_id' => $ratio->currencyA->id,
                'amount' => $order->tradable_ratio,
                'user_id' => $order->user_id,
            ]);

            $inventory = Inventory::query()->lockForUpdate()->find($ratio->currencyA->id);
            $inventory->amount -= $order->tradable_ratio;
            $inventory->save();

            $order->update(['status' => 'done']);

        }

    }

}
