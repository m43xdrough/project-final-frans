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
        Schema::create('tsoh', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('resep_id');
            $table->string('notrans', 15);
            $table->date('tgltrans');
            $table->float('subtotal', 10, 2);
            $table->float('totdisc', 10, 2);
            $table->float('totppn', 10, 2);
            $table->float('grandtotal', 10, 2);

            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
            $table->foreign('resep_id')->references('id')->on('tresep');
            //$table->index(['kode', 'nama', 'email', 'tgllahir']);
            $table->unique(['notrans', 'tgltrans']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsoh');
    }
};
