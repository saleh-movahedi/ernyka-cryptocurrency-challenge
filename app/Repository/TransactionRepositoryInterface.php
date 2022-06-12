<?php

namespace App\Repository;

use App\Repository\Eloquent\OrderRepository;
use Illuminate\Database\Eloquent\Model;

/**\
 * @see
*/
interface TransactionRepositoryInterface extends EloquentRepositoryInterface
{

    public function all();
}
