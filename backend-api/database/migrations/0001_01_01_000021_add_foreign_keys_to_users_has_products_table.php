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
        Schema::table('users_has_products', function (Blueprint $table) {
            $table->foreign(['product_id'], 'fk_user_has_products_products1')->references(['id'])->on('products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_ID'], 'fk_user_has_products_user1')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_has_products', function (Blueprint $table) {
            $table->dropForeign('fk_user_has_products_products1');
            $table->dropForeign('fk_user_has_products_user1');
        });
    }
};
