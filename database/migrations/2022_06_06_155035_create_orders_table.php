<?php

use App\Models\Ratio;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class);
            $table->unsignedBigInteger('exchangeable_id');
            $table->double('tradable_ratio', 15, 8);
            $table->double('amount', 15, 8)->default(0);
            $table->enum('status', ['ordered', 'in-progress', 'done', 'failed'])->default('ordered');
            $table->enum('type', ['buy', 'sell']);

            $table->foreign('exchangeable_id')->references('id')->on('ratios')
                ->restrictOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('orders');
    }
}
