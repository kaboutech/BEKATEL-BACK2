<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePickupRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickup_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('adress', 200);
            $table->string('product_name', 50);
            $table->integer('quantity');
            $table->timestamps();
            $table->unsignedInteger('customer_id')->notNull();
            $table->unsignedInteger('city_id')->notNull();
            $table->unsignedInteger('product_type_id')->notNull();
            $table->unsignedBigInteger('pickup_status_id')->notNull();
            
           
        });


        Schema::table('pickup_requests', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_type_id')->references('id')->on('product_type')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pickup_status_id')->references('id')->on('pickup_status')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pickup_requests');
    }
}
