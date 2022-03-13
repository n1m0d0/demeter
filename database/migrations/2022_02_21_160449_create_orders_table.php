<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('way_id');
            $table->dateTime('delivery');
            $table->string('received_by');
            $table->string('address')->nullable();
            $table->float('advance', 10, 2)->default(0);
            $table->enum('status', [
                Order::REGISTRADO,
                Order::ACTIVO,
                Order::INACTIVO,
                Order::ENTREGADO
            ])->default(Order::REGISTRADO);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('way_id')->references('id')->on('ways');
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
};
