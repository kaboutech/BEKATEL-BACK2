<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments("id");
            $table->string('name', 150)->notNull();
            $table->text('description')->notNull();
            $table->float('price')->notNull();
            $table->unsignedInteger('product_type_id')->notNull();
            $table->unsignedInteger('warehouse_id')->notNull();
            $table->unsignedInteger('product_categorie_id')->notNull();
            $table->string('image', 130)->nullable();
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('product_type_id')
                ->references('id')
                ->on('product_type')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('product_categorie_id')
                ->references('id')
                ->on('product_categories')
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
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['product_type_id']);
            $table->dropForeign(['warehouse_id']);
            $table->dropForeign(['product_categorie_id']);
        });

        Schema::dropIfExists('products');
    }
}
