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
        Schema::create('formulations_has_heat_treatments', function (Blueprint $table) {
            $table->unsignedBigInteger('heat_treatment_id')->index('heat_treatment_id');
            $table->unsignedBigInteger('formulation_id')->index('formulation_id');
            $table->primary(['heat_treatment_id', 'formulation_id']);
            $table->foreign('heat_treatment_id')
                ->references('id')->on('heat_treatments')
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
        Schema::dropIfExists('formulations_has_heat_treatments');
    }
};
