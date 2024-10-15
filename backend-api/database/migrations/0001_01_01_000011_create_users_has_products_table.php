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
            $table->unsignedBigInteger('user_id')->index('fk_user_has_product_user_idx');
            $table->unsignedBigInteger('product_id')->index('fk_user_has_product_product_idx');
            $table->primary(['user_id', 'product_id']);
            // Создание внешних ключей
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('NO ACTION')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('NO ACTION')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_has_products');
    }
};
