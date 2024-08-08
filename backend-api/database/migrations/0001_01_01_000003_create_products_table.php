<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45)->nullable();
            $table->float('protein', 10, 0)->nullable();
            $table->float('carbs', 10, 0)->nullable();
            $table->float('fat', 10, 0)->nullable();
            $table->float('water', 10, 0)->nullable();
            $table->float('fiber', 10, 0)->nullable();
            $table->float('ash', 10, 0)->nullable();
            $table->unsignedBigInteger('category_id')->index('fk_products_category1_idx');
            $table->foreign('category_id', 'fk_products_categories1')->on('categories')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
