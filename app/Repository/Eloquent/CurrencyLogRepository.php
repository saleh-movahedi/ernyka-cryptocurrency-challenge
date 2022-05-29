<?php


namespace App\Repository\Eloquent;

use App\Models\Currency;
use App\Models\CurrencyLog;
use App\Repository\CurrencyRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * @see CurrencyLog
*/

class CurrencyLogRepository extends BaseRepository implements CurrencyRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param Currency $model
     */
    public function __construct(Currency $model)
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


}
