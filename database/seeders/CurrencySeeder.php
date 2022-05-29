<?php

namespace Database\Seeders;

use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Database\Seeder;


class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::query()->insert(
            [
                [
                    'name' => 'bitcoin',
                    'slug' => 'BTC',
                    'price' => 0,
                    "created_at" => Carbon::now(), "updated_at" => now()
                ],
                [
                    'name' => 'tether',
                    'slug' => 'USDT',
                    'price' => 0,
                    "created_at" => Carbon::now(), "updated_at" => now()
                ],
                [
                    'name' => 'ethereum',
                    'slug' => 'ETH',
                    'price' => 0,
                    "created_at" => Carbon::now(), "updated_at" => now()

                ],
                [
                    'name' => 'shiba-inu',
                    'slug' => 'SHIB',
                    'price' => 0,
                    "created_at" => Carbon::now(), "updated_at" => now()
                ],
            ]
        );
    }
}
