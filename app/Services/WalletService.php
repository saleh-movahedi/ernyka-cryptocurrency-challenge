<?php

namespace App\Services;

use App\Repository\WalletRepositoryInterface;

class WalletService
{
    private WalletRepositoryInterface $walletRepository;

    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function getUserWallet($userId, $currencyId)
    {
        return $this->walletRepository->getUserWallet($userId, $currencyId);
    }


}
