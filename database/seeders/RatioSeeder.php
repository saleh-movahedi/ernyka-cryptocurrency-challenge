<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Ratio;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RatioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = Currency::all();
        $coins = [
            'tether' => $currencies->where('name', 'tether')->first(),
            'bitcoin' => $currencies->where('name', 'bitcoin')->first(),
            'shiba-inu' => $currencies->where('name', 'shiba-inu')->first(),
            'ethereum' => $currencies->where('name', 'ethereum')->first(),
        ];

        Ratio::query()->insert(
            [
                [
                    'currency_a_id' => $coins['tether']->id,
                    'currency_b_id' => $coins['bitcoin']->id,
                    'title' => "{$coins['tether']->slug}/{$coins['bitcoin']->slug}",
                    "created_at" => Carbon::now(), "updated_at" => now()
                ],
                [
                    'currency_a_id' => $coins['tether']->id,
                    'currency_b_id' => $coins['shiba-inu']->id,
                    'title' => "{$coins['tether']->slug}/{$coins['shiba-inu']->slug}",
                    "created_at" => Carbon::now(), "updated_at" => now()
                ],
                [
                    'currency_a_id' => $coins['tether']->id,
                    'currency_b_id' => $coins['ethereum']->id,
                    'title' => "{$coins['tether']->slug}/{$coins['ethereum']->slug}",
                    "created_at" => Carbon::now(), "updated_at" => now()
                ],
                [
                    'currency_a_id' => $coins['bitcoin']->id,
                    'currency_b_id' => $coins['ethereum']->id,
                    'title' => "{$coins['bitcoin']->slug}/{$coins['ethereum']->slug}",
                    "created_at" => Carbon::now(), "updated_at" => now()
                ],
            ]
        );
    }
}
