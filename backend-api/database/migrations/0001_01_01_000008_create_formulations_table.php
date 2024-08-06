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
            $table->increments('id');
            $table->string('netto', 45)->nullable();
            $table->string('brutto', 45)->nullable();
            $table->string('package', 45)->nullable();
            $table->string('product_id', 45)->nullable();
            $table->unsignedInteger('ttk_id')->index('fk_formulations_ttk_idx');
            $table->unsignedBigInteger('initial_processing_id')->index('fk_formulations_initial_processing1_idx');
            $table->foreign('initial_processing_id', 'fk_formulations_initial_processings1')->on('initial_processings')->references('id');
            $table->unsignedBigInteger('heat_treatment_id')->index('fk_formulations_heat_treatment1_idx');
            $table->foreign('heat_treatment_id', 'fk_formulations_heat_treatments1')->on('heat_treatments')->references('id');
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
