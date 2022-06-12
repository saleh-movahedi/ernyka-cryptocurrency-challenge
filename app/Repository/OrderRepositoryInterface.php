<?php

namespace App\Repository;

use App\Models\Order;
use App\Repository\Eloquent\OrderRepository;
use Illuminate\Database\Eloquent\Model;

/**\
 * @see OrderRepository
 */
interface OrderRepositoryInterface extends EloquentRepositoryInterface
{

    public function all();

    public function getUnprocessedOrders();
}
