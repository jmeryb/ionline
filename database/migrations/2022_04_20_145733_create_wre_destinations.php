<?php

use App\Models\Warehouse\Destination;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWreDestinations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wre_destinations', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255)->nullable();
            $table->foreignId('store_id')->nullable()->constrained('wre_stores');

            $table->timestamps();
            $table->softDeletes();
        });

        // TODO: Eliminar
        Destination::create([
            'name' => 'Destino X',
            'store_id' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wre_store_destinations');
    }
}
