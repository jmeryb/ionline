<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProProgrammingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_programming_items', function (Blueprint $table) {
            $table->id();
            $table->string('cycle')->nullable();
            $table->string('action_type')->nullable();
            $table->string('ministerial_program')->nullable();
            $table->string('activity_name')->nullable();
            $table->string('def_target_population')->nullable();
            $table->string('source_population')->nullable();
            $table->integer('cant_target_population')->nullable();
            $table->decimal('prevalence_rate',5,1)->nullable();
            $table->string('source_prevalence')->nullable();
            $table->decimal('coverture',5,1)->nullable();
            $table->integer('population_attend')->nullable(); // Población a atender
            $table->integer('concentration')->nullable(); // Cantidad de veces que debo darle control anual
            $table->integer('activity_total')->nullable();
            $table->string('professional')->nullable();
            $table->integer('activity_performance')->nullable();
            $table->decimal('hours_required_year',5,1)->nullable();
            $table->decimal('hours_required_day',5,2)->nullable();
            $table->decimal('direct_work_year',5,2)->nullable(); // Jornadas Directas Año
            $table->decimal('direct_work_hour',5,4)->nullable(); // Jornadas Horas Directas Diarias
            $table->string('information_source')->nullable();
            $table->string('prap_financed')->nullable();
            $table->string('observation')->nullable();

            $table->bigInteger('programming_id')->unsigned();
 
            $table->foreign('programming_id')->references('id')->on('pro_programmings');
            
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pro_programming_items');
    }
}
