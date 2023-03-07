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
        Schema::create('mmaterial', function (Blueprint $table) {
            $table->id();
            $table->string('kdbarang', 20)->unique();
            $table->string('namabarang', 200)->nullable(false);
            $table->decimal('harga', 10, 2);
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
            $table->index(['kdbarang', 'namabarang']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mmaterial');
    }
};
