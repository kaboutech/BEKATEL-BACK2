<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_payment_details', function (Blueprint $table) {
            $table->unsignedInteger('driver_payment_id')->notNull();
            $table->unsignedInteger('order_id')->notNull();

        });


        Schema::table('driver_payment_details', function (Blueprint $table) {
            $table->foreign('driver_payment_id')
                ->references('id')->on('driver_payment')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('order_id')
                ->references('id')->on('orders')
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
        Schema::dropIfExists('driver_payment_details');
    }
}
