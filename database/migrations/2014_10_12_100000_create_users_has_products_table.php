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
            $table->unsignedInteger('users_ID')->index('fk_users_has_products_user1_idx');
            $table->unsignedInteger('products_id')->index('fk_users_has_products_products1_idx');

            $table->primary(['users_ID', 'products_id']);
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
