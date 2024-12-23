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
        Schema::create('quality_requirements', function (Blueprint $table) {
            $table->id();
            $table->string('description', 2000)->nullable();
            $table->unsignedBigInteger('ttk_id')->index('fk_quality_requirement_ttk_idx');
            $table->foreign(['ttk_id'], 'fk_quality_requirement_ttk1')->references(['id'])->on('ttks')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quality_requirements');
    }
};
