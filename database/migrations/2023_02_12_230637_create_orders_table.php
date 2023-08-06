<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id')->unsigned()->notNull();
            $table->unsignedInteger('driver_id')->unsigned()->notNull();
            $table->unsignedInteger('receiver_id')->unsigned()->notNull();
            $table->unsignedInteger('order_status_id')->unsigned()->notNull();
            $table->string('delay',50);
            $table->timestamps();


        });


        Schema::table('orders', function (Blueprint $table) {

            $table->foreign('customer_id')
                  ->references('id')->on('customers')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('driver_id')
                  ->references('id')->on('drivers')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('receiver_id')
                  ->references('id')->on('receiver')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('order_status_id')
                  ->references('id')->on('order_status')
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
        Schema::dropIfExists('orders');
    }
}
