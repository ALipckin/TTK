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
        Schema::create('org_characteristics', function (Blueprint $table) {
            $table->id();
            $table->text('view')->nullable();
            $table->string('color')->nullable();
            $table->string('cons')->nullable();
            $table->string('taste')->nullable();
            $table->unsignedBigInteger('ttk_id')->index('fk_org_characteristics_ttks_idx');
            $table->foreign(['ttk_id'], 'fk_org_characteristics_ttks')
                ->references(['id'])->on('ttks')
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
        Schema::dropIfExists('org_characteristics');
    }
};
