<?php

namespace App\Services;

use App\Jobs\CurrencyPriceFetchServiceJob;
use App\Repository\CurrencyRepositoryInterface;
use App\Repository\Eloquent\CurrencyRepository;
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


    public function saveCurrencies($priceList)
    {
        $currencies = $this->currencyRepository->getCurrenciesByName(array_keys($priceList));

        foreach ($currencies as $currencyItem) {
            $this->currencyRepository->UpdateCurrencyPrice($currencyItem, $priceList[$currencyItem->name]/*+rand(1000, 2000)*/);
        }

        Log::info(['after update database' => $currencies->toArray()]);
    }

}
