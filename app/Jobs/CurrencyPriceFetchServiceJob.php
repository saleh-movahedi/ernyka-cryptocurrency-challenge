<?php

namespace App\Jobs;

use App\Repository\Eloquent\CurrencyRepository;
use App\Services\CurrencyService;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CurrencyPriceFetchServiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var CurrencyService
     */
    private $currencyService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @param CurrencyService $currencyService
     * @param CurrencyRepository $currencyRepository
     * @return void
     * @throws \Exception
     */
    public function handle(CurrencyService $currencyService, CurrencyRepository $currencyRepository)
    {
        $client = new CoinGeckoClient();
        $currencies = $currencyRepository->getAllCurrencies();
        $currencyList = implode(',', $currencies);

        $data = $client->simple()->getPrice($currencyList, 'usd');

        $data = array_map(function ($item) {
            return $item['usd'];
        }, $data);

        $currencyService->saveCurrencies($data);

    }
}
