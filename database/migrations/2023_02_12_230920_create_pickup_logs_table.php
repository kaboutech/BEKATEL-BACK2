<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePickupLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickup_logs', function (Blueprint $table) {
            $table->increments("id");
            $table->string('adresse', 200);
            $table->string('name', 50);
            $table->string('email', 100);
            $table->unsignedInteger('cities_id')->unsigned()->notNull();
            $table->timestamps();
        });

        Schema::table('pickup_logs', function (Blueprint $table) {
            $table->foreign('cities_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');

            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pickup_logs');
    }
}
