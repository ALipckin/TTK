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
        Schema::create('headers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company', 100)->nullable();
            $table->string('property', 100)->nullable();
            $table->string('position', 70)->nullable();
            $table->string('approver', 100)->nullable();
            $table->unsignedInteger('card')->nullable();
            $table->date('created_date')->nullable();
            $table->string('dish', 80)->nullable();
            $table->string('dev', 100)->nullable();
            $table->string('approver2', 100)->nullable();
            $table->string('approver2_position', 70)->nullable();
            $table->unsignedInteger('ttk_id')->index('fk_headers_ttks_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('headers');
    }
};
