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
        Schema::create('formulations', function (Blueprint $table) {
            $table->id();
            $table->string('netto', 45)->nullable();
            $table->string('brutto', 45)->nullable();
            $table->unsignedBigInteger('product_id')->index('product_id');
            $table->unsignedBigInteger('package_id')->nullable()->index('package_id');
            $table->unsignedBigInteger('ttk_id')->index('ttk_id');

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');

            $table->foreign('package_id')
                ->references('id')->on('packages')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');
            
            $table->foreign('ttk_id')
                ->references('id')->on('ttks')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formulations');
    }
};
