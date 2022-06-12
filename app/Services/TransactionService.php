<?php

namespace App\Services;

use App\Repository\TransactionRepositoryInterface;

class TransactionService
{
    private TransactionRepositoryInterface $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }
}
