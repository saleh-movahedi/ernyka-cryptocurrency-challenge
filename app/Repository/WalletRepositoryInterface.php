<?php

namespace App\Repository;

use App\Repository\Eloquent\OrderRepository;
use Illuminate\Database\Eloquent\Model;

/**\
 * @see WalletRepository
*/
interface WalletRepositoryInterface extends EloquentRepositoryInterface
{

    public function all();

    public function getUserWallet($userId, $currencyId);
}
