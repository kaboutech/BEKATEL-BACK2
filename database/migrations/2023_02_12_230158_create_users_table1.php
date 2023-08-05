<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('name', 50)->nullable(false);
            $table->integer('phone')->unsigned()->nullable(false);
            $table->string('email', 100)->nullable(false)->unique();
            $table->string('password', 40)->nullable(false);
            $table->string('adress', 200)->nullable(false);
            $table->timestamps();
            $table->unsignedInteger('role_id')->notNull();



        
        });
        Schema::table('users', function (Blueprint $table) {

            $table->foreign('role_id')
            ->references('id')
            ->on('roles')
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
        Schema::dropIfExists('users');
    }
}
