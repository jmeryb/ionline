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
        Schema::create('well_bnf_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subsidy_id')->constrained('well_bnf_subsidies');
            $table->foreignId('applicant_id')->constrained('users');
            $table->text('status'); //en revisión, aceptado, rechazado
            $table->datetime('status_update_date')->nullable();
            $table->foreignId('status_update_responsable_id')->nullable()->constrained('users');
            $table->text('status_update_observation')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('well_bnf_requests');
    }
};
