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
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('cold', 5, 2)->nullable();
            $table->float('hot', 5, 2)->nullable();
            $table->float('fin', 5, 2)->nullable();
            $table->float('protein', 5, 2)->nullable();
            $table->float('fat', 5, 2)->nullable();
            $table->float('carbs', 5, 2)->nullable();
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
        Schema::dropIfExists('heat_treatments');
    }
};
