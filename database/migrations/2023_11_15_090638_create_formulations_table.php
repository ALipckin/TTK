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
            $table->string('description', 1000)->nullable();
            $table->string('netto', 45)->nullable();
            $table->string('brutto', 45)->nullable();
            $table->string('package', 45)->nullable();
            $table->string('name', 45)->nullable();
            $table->unsignedInteger('ttk_id')->index('fk_formulations_ttk_idx');
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
