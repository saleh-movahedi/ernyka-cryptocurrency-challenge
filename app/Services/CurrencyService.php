<?php /** @noinspection PhpMissingReturnTypeInspection */

namespace App\Services;

use App\Jobs\CurrencyPriceFetchServiceJob;
use App\Models\Currency;
use App\Models\Ratio;
use App\Repository\CurrencyRepositoryInterface;
use App\Repository\Eloquent\CurrencyRepository;
use App\Repository\RatioRepositoryInterface;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    /**
     * @var CurrencyRepository
     */
    private $currencyRepository;
    /**
     * @var RatioRepositoryInterface
     */
    private $ratioRepository;

    public function __construct(
        CurrencyRepositoryInterface $currencyRepository,
        RatioRepositoryInterface $ratioRepository
    )
    {
        $this->currencyRepository = $currencyRepository;
        $this->ratioRepository = $ratioRepository;
    }


    public function fetchPricesFromThirdParty()
    {
        CurrencyPriceFetchServiceJob::dispatch(/*$currencies*/);
    }


    /**
     * store from third party
     *
     * @param $priceList
     * @return void
     */
    public function saveCurrencies($priceList)
    {
        $currencies = $this->currencyRepository->getCurrenciesByName(array_keys($priceList));
        $ratios = $this->ratioRepository->all();

        /** @var Currency $currencyItem */
        foreach ($currencies as $currencyItem) {
            $this->currencyRepository->UpdateCurrencyPrice($currencyItem, $priceList[$currencyItem->name]);
        }

        // calculating ratio between currency pairs
        foreach ($ratios as $ratioItem) {
            $newRationValue =
                $currencies->where('id', $ratioItem->currency_a_id)->first()->price /
                $currencies->where('id', $ratioItem->currency_b_id)->first()->price;
            $ratioItem->update(['value' => $newRationValue]);
        }

        Log::info(['after update database' => $currencies->toArray()]);
    }


    /**
     * crud
     *
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function storeCurrency($data)
    {
        return $this->currencyRepository->create($data);
    }


    /**
     * @param $currencyId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function showCurrency($currencyId)
    {
        return $this->currencyRepository->find($currencyId);
    }


    public function updateCurrency($id, array $data)
    {
        return $this->currencyRepository->update($id, $data);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function remoteFetchAllCurrencies()
    {
        $client = new CoinGeckoClient();
        return $client->coins()->getList();

    }

    /**
     * @param $id
     * @return bool|mixed|null
     */
    public function delete($id)
    {
        return $this->currencyRepository->delete($id);
    }
}
