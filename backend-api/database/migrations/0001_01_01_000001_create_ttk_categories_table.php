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
        Schema::create('ttk_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text("view")->nullable();
            $table->string("color")->nullable();
            $table->string("cons")->nullable();
            $table->string("taste")->nullable();
            $table->float('fat', 5, 2)->nullable();
            $table->float("fdry", 5, 2)->nullable();
            $table->float("ffat", 5, 2)->nullable();
            $table->float("fsug", 5, 2)->nullable();
            $table->float("fsalt", 5, 2)->nullable();
            $table->float("gerb", 5, 2)->nullable();
            $table->string("kma", 30)->nullable();

            $table->string("bgkp", 20)->nullable();
            $table->string("ecoli", 20)->nullable();
            $table->string("saur", 20)->nullable();
            $table->string("prot", 20)->nullable();
            $table->string("pato", 20)->nullable();

            $table->float("dryk", 5, 2)->nullable();
            $table->float("smax", 5, 2)->nullable();
            $table->string("sp")->nullable();
            $table->text("rem")->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('ttk_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ttk_categories');
    }
};
