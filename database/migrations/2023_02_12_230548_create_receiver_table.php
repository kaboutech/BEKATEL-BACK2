<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receiver', function (Blueprint $table) {
            $table->increments('id');
            $table->string('adresse', 200)->notNull();
            $table->string('name', 70)->notNull();
            $table->integer('phone')->notNull();
            $table->string('email', 160)->notNull();
            $table->unsignedInteger('city_id')->unsigned()->notNull();
            $table->timestamps();

       
        });

        
        Schema::table('receiver', function (Blueprint $table) {

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
        Schema::dropIfExists('receiver');
    }
}
