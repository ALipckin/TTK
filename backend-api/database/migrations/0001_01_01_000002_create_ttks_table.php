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
        Schema::create('ttks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45)->nullable();
            $table->string('image')->nullable();
            $table->boolean('public')->nullable()->default(false);
            $table->unsignedBigInteger('user_id')->index('fk_ttk_user_idx');
            $table->boolean('isDraft')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ttks');
    }
};
