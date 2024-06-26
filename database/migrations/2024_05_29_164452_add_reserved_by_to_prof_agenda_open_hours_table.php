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
        Schema::table('prof_agenda_open_hours', function (Blueprint $table) {
            $table->foreignId('reserver_id')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prof_agenda_open_hours', function (Blueprint $table) {
            $table->dropForeign(['reserver_id']);
            $table->dropColumn('reserver_id');
        });
    }
};
