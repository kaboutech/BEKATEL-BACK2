<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('name', 50)->nullable(false);
            $table->integer('phone')->unsigned()->nullable(false);
            $table->string('email', 100)->nullable(false)->unique();
            $table->string('password', 40)->nullable(false);
            $table->string('adress', 200)->nullable(false);
            $table->unsignedInteger('car_id')->notNull();
            $table->unsignedInteger('city_id')->notNull();
            $table->float('price_per_order');
            $table->timestamps();

          
        });

        Schema::table('drivers', function (Blueprint $table) {

            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');

            });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers');
    }
}
