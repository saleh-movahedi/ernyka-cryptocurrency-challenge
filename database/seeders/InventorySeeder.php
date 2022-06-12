<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::all()->map(function (Currency $item) {
            $item->inventory()->create([
                'amount' => 100000
            ]);
        });
    }
}
