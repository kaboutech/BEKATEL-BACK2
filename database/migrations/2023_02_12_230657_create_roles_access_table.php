<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_access', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned()->notNull();
            $table->string('section', 60);
            $table->timestamps();

         
        });

        
        Schema::table('roles_access', function (Blueprint $table) {
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
        Schema::dropIfExists('roles_access');
    }
}
