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
        Schema::create('formulations_has_initial_treatments', function (Blueprint $table) {
            $table->unsignedBigInteger('initial_treatment_id')->index('initial_treatment_id');
            $table->unsignedBigInteger('formulation_id')->index('formulation_id');
            $table->primary(['initial_treatment_id', 'formulation_id']);
            
            $table->foreign('initial_treatment_id')
                ->references('id')->on('initial_treatments')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');

            $table->foreign('formulation_id')
                ->references('id')->on('formulations')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulations_has_initial_treatments');
    }
};
