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
        Schema::create('users_has_products', function (Blueprint $table) {
            $table->unsignedInteger('user_ID')->index('fk_user_has_product_user_idx');
            $table->unsignedInteger('product_id')->index('fk_user_has_product_product_idx');

            $table->primary(['user_ID', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_has_products');
    }
};
