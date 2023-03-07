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
        Schema::create('mmember', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('nama', 200)->nullable(false);
            $table->string('email', 200);
            $table->string('no_hp', 20);
            $table->date('tgllahir')->nullable(false);
            $table->string('jnskelamin', 10);
            $table->string('xpassword', 20);
            $table->string('alamat', 200);
            $table->string('kota', 100);
            $table->string('provinsi', 100);
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
            $table->index(['kode', 'nama', 'email', 'tgllahir']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mmember');
    }
};
