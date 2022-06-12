<?php


namespace App\Repository\Eloquent;

use App\Models\Currency;
use App\Models\CurrencyLog;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Repository\CurrencyRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\TransactionRepositoryInterface;
use App\Repository\WalletRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * @see CurrencyLog
 */
class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param Transaction $model
     */
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->newQuery()->select('*')->get();
    }


    public function getUserWallet($userId, $currencyId)
    {
        return $this->model->newQuery()
            ->where('user_id', $userId)
            ->where('currency_id', $currencyId)
            ->first();
    }
}
