<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarTypeTable extends Migration
{
    public function up()
    {
        Schema::create('car_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type',50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('car_type');
    }
}
