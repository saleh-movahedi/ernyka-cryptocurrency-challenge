<?php


namespace App\Repository\Eloquent;

use App\Models\Ratio;
use App\Repository\RatioRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class RatioRepository extends BaseRepository implements RatioRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param Ratio $model
     */
    public function __construct(Ratio $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->newQuery()->select(
            ['id', 'title', 'currency_a_id', 'currency_b_id', 'value']
        )->get();
    }


    public function find($id): ?Ratio
    {
        return $this->model->newQuery()->find($id, ['id', 'title', 'currency_a_id', 'currency_b_id', 'value']);
    }


    public function getRatiosWithCurrencies($exchangeable_id) : Ratio
    {
        return $this->model
            ->newQuery()
            ->select(['id', 'title', 'currency_a_id', 'currency_b_id', 'value'])
            ->where('id', $exchangeable_id)
            ->with(['currencyA:id,name,slug,price', 'currencyB:id,name,slug,price'])
            ->first();
    }

}
