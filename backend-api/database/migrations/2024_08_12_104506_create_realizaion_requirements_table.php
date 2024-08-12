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
        Schema::create('realization_requirements', function (Blueprint $table) {
            $table->id();
            $table->string('description', 2000)->nullable();
            $table->unsignedBigInteger('ttk_id')->index('fk_realization_requirement_ttk_idx');
            $table->foreign(['ttk_id'], 'fk_realization_requirement_ttk')->references(['id'])->on('ttks')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realization_requirements');
    }
};
