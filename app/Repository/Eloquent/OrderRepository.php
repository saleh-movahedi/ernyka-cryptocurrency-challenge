<?php


namespace App\Repository\Eloquent;

use App\Models\Currency;
use App\Models\CurrencyLog;
use App\Models\Order;
use App\Repository\CurrencyRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * @see CurrencyLog
 */
class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param Order $model
     */
    public function __construct(Order $model)
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


    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUnprocessedOrders() :\Illuminate\Database\Eloquent\Collection
    {
        return $this->model
            ->newQuery()
            ->where('status', 'ordered')
            ->get([
                'id',
                'user_id',
                'exchangeable_id',
                'tradable_ratio',
                'amount',
                'status',
                'type',
            ]);
    }
}
