<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tsod', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tsoh_id');
            $table->bigInteger('material_id');
            $table->integer('nourut');
            $table->float('qty', 10, 2);
            $table->float('harga', 10, 2);
            $table->float('disc', 10, 2);
            $table->float('ndisc', 10, 2);
            $table->float('ppn', 10, 2);
            $table->float('nppn', 10, 2);
            $table->float('total', 10, 2);

            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
            $table->foreign('tsoh_id')->references('id')->on('tsoh');
            $table->foreign('material_id')->references('id')->on('mmaterial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsod');
    }
};
