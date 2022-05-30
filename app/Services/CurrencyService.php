<?php /** @noinspection PhpMissingReturnTypeInspection */

namespace App\Services;

use App\Jobs\CurrencyPriceFetchServiceJob;
use App\Repository\CurrencyRepositoryInterface;
use App\Repository\Eloquent\CurrencyRepository;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    /**
     * @var CurrencyRepository
     */
    private $currencyRepository;

    public function __construct(CurrencyRepositoryInterface $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }


    public function fetchPricesFromThirdParty()
    {
        $currencies = $this->currencyRepository->getAllCurrencies();
        $currencies = implode(',', $currencies);
        CurrencyPriceFetchServiceJob::dispatch($currencies);
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

        foreach ($currencies as $currencyItem) {
            $this->currencyRepository->UpdateCurrencyPrice($currencyItem, $priceList[$currencyItem->name]/*+rand(1000, 2000)*/);
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
