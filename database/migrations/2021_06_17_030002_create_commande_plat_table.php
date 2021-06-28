<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandePlatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commande_plat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')
                    ->constrained()
                    ->cascadeOnDelete();
                    
            $table->foreignId('plat_id')    
                    ->constrained()
                    ->cascadeOnDelete();
                    
            $table->integer('qte');

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
        Schema::dropIfExists('commande_plat');
    }
}
