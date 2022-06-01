<?php


namespace App\Repository\Eloquent;

use App\Models\Currency;
use App\Repository\CurrencyRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CurrencyRepository extends BaseRepository implements CurrencyRepositoryInterface
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
        return $this->model->newQuery()->select(['id', 'name', 'slug', 'price'])->get();
    }

    public function getAllCurrencies(): array
    {
        return $this->model->newQuery()
            ->select(['name'])
            ->get()
            ->pluck('name')
            ->toArray();
    }

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCurrenciesByName($data)
    {
        return $this->model->newQuery()
            ->select(['id', 'name', 'price'])
            ->whereIn('name', $data)
            ->get();
    }

    /**
     * @param Currency $currencyItem
     * @param $price
     * @return void
     */
    public function UpdateCurrencyPrice(Currency $currencyItem, $price)
    {
        $currencyItem->update(['price' => $price]);
        $currencyItem->currencyLog()->newQuery()->create(['price' => $price]);
    }

    public function find($id): ?Model
    {
        return $this->model->newQuery()->find($id, ['id', 'name', 'slug', 'price']);
    }

    public function update($id, $data)
    {
        return $this->model->newQuery()->find($id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->newQuery()->findOrFail($id)->delete();
    }
}
