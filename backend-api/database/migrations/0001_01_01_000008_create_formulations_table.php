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
        Schema::create('formulations', function (Blueprint $table) {
            $table->id();
            $table->string('netto', 45)->nullable();
            $table->string('brutto', 45)->nullable();
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('ttk_id');
            $table->unsignedBigInteger('initial_processing_id');
            $table->unsignedBigInteger('heat_treatment_id');

            // Adding indexes
            $table->index('ttk_id');
            $table->index('package_id');
            $table->index('initial_processing_id');
            $table->index('heat_treatment_id');

            $table->foreign('package_id')
                ->references('id')->on('packages')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');

            // Adding foreign keys
            $table->foreign('initial_processing_id')
                ->references('id')->on('initial_processings')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');

            $table->foreign('heat_treatment_id')
                ->references('id')->on('heat_treatments')
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
