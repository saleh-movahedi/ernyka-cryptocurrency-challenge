<?php

use App\Models\Currency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratios', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('currency_a_id');
            $table->unsignedBigInteger('currency_b_id');
            $table->double('value', 15, 8)->default(0);

            $table->foreign('currency_a_id')->references('id')->on('currencies')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('currency_b_id')->references('id')->on('currencies')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratios');
    }
}
