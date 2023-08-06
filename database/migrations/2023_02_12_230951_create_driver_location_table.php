<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_location', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('driver_id')->unsigned()->notNull();
            $table->timestamp('time')->useCurrent();
            $table->float('latitude')->nullable(false);
            $table->float('longitude')->nullable(false);
            $table->timestamps();
        });

        Schema::table('driver_location', function (Blueprint $table) {
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade')->onUpdate('cascade');

            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_location');
    }
}
