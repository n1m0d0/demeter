<?php

use App\Models\Personalization;
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
        Schema::create('personalizations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_id');
            $table->string('image')->nullable();
            $table->tinyText('description');
            $table->enum('status', [
                Personalization::ACTIVO,
                Personalization::INACTIVO
            ])->default(Personalization::ACTIVO);
            $table->timestamps();

            $table->foreign('detail_id')->references('id')->on('details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personalizations');
    }
};
