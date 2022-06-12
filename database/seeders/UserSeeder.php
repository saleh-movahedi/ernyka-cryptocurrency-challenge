<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create()
            ->map(/**
             * @return void
             */ function (User $userItem) {
                /** @var Currency $currency */
                foreach (Currency::all() as $currency) {
                    $userItem->wallets()->create([
                        'currency_id' => $currency->id,
                        'amount' => '10000'
                    ]);
                }
            });
    }
}
