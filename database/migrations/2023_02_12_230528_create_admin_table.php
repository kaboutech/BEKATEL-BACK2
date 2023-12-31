<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('name', 50)->nullable(false);
            $table->integer('phone')->unsigned()->nullable(false);
            $table->string('email', 100)->nullable(false)->unique();
            $table->string('password', 40)->nullable(false);
            $table->string('adress', 200)->nullable(false);
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
        Schema::dropIfExists('admin');
    }
}
