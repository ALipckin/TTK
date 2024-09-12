<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('unit')->nullable();
            $table->integer('grm')->nullable();
            $table->float('protein', 5, 2)->nullable();
            $table->float('fat', 5, 2)->nullable();
            $table->float('carbs', 5, 2)->nullable();
            $table->float('water', 5, 2)->nullable();
            $table->float('fiber', 5, 2)->nullable();
            $table->float('dry', 5, 2)->nullable();
            $table->float('alko', 5, 2)->nullable();
            $table->float('sug', 5, 2)->nullable();
            $table->float('ash', 5, 2)->nullable();
            $table->text('rem')->nullable();
            $table->unsignedBigInteger('user_id')->index('fk_ttks_user_idx')->nullable();
            $table->unsignedBigInteger('category_id')->index('fk_products_category1_idx');
            $table->foreign('user_id', 'fk_products_users1')->on('users')->references('id');
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
