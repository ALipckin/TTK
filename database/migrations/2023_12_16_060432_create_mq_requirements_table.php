<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mq_requirements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description', 2000)->nullable();
            $table->unsignedInteger('ttk_id')->index('fk_mq_requirements_ttk_idx');
            $table->foreign(['ttk_id'], 'fk_mq_requirements_ttk1')->references(['id'])->on('ttks')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table->dropForeign('fk_mq_requirements_ttk1');
        Schema::dropIfExists('mq_requirements');
    }
};
