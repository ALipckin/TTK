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
        Schema::create('ttks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45)->nullable();
            $table->string('image')->nullable();
            $table->boolean('public')->nullable()->default(false);
            $table->unsignedBigInteger('user_id')->index('fk_ttks_user_idx');
            $table->boolean('is_draft')->nullable();
            $table->unsignedBigInteger('category_id')->index('fk_ttk_category_idx');
            $table->foreign('category_id', 'fk_ttks_ttk_categories')->on('ttk_categories')->references('id');
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
