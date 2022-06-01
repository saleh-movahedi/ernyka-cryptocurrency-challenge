<?php

namespace App\Repository;

use App\Repository\Eloquent\CurrencyRepository;
use Illuminate\Database\Eloquent\Model;

/**\
 * @see CurrencyRepository
*/
interface RatioRepositoryInterface extends EloquentRepositoryInterface
{

    public function all();
    public function find($id): ?Model;
}
