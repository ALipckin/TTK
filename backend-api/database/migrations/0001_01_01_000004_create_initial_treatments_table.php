<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('initial_treatments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('loss');
            $table->unsignedBigInteger('product_id')->index('product_id');

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('initial_treatments');
    }
};
