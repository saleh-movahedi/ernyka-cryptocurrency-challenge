<?php

namespace App\Repository;

use App\Repository\Eloquent\CurrencyRepository;
use Illuminate\Database\Eloquent\Model;

/**\
 * @see CurrencyRepository
*/
interface CurrencyLogRepositoryInterface extends EloquentRepositoryInterface
{

    public function all();
}
