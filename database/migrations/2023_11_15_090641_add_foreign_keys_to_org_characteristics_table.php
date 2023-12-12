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
        Schema::table('org_characteristics', function (Blueprint $table) {
            $table->foreign(['ttk_id'], 'fk_org_characteristics_ttks')->references(['id'])->on('ttks')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('org_characteristics', function (Blueprint $table) {
            $table->dropForeign('fk_org_characteristics_ttks');
        });
    }
};
