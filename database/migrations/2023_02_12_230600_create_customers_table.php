<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('name', 50)->nullable(false);
            $table->integer('phone')->unsigned()->nullable(false);
            $table->string('email', 100)->nullable(false)->unique();
            $table->string('password', 40)->nullable(false);
            $table->string('adress', 200)->nullable(false);
            $table->string('company_name', 50)->nullable();
            $table->string('company_logo', 150)->nullable();
            $table->string('If', 50)->nullable();
            $table->string('Ice', 100)->nullable();
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
        Schema::dropIfExists('customers');
    }
}
