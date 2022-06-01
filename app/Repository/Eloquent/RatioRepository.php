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
        return $this->model->newQuery()->select(['*'])->get();
    }


    public function find($id): ?Model
    {
        return $this->model->newQuery()->find($id, ['id', 'name', 'slug', 'price']);
    }

}
