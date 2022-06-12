<?php

namespace App\Providers;

use App\Repository\CurrencyRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\CurrencyRepository;
use App\Repository\Eloquent\OrderRepository;
use App\Repository\Eloquent\RatioRepository;
use App\Repository\Eloquent\TransactionRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Eloquent\WalletRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\RatioRepositoryInterface;
use App\Repository\TransactionRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\WalletRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CurrencyRepositoryInterface::class, CurrencyRepository::class);
        $this->app->bind(RatioRepositoryInterface::class, RatioRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(WalletRepositoryInterface::class, WalletRepository::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
