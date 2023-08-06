<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->notNull();
            $table->string('matricule', 50)->notNull();
            $table->string('responsable', 50)->nullable();
            $table->unsignedBigInteger('car_type_id')->notNull();
            $table->timestamps();


        });

        Schema::table('cars', function (Blueprint $table) {
            $table->foreign('car_type_id')
            ->references('id')
            ->on('car_type')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
