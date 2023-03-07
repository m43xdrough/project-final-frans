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
        Schema::create('tresep', function (Blueprint $table) {
            $table->id();
            $table->string('noresep', 15);
            $table->date('tglresep');
            $table->bigInteger('member_id');
            $table->string('chspherisr', 10);
            $table->string('chspherisl', 10);
            $table->string('chcylinderr', 10);
            $table->string('chcylinderl', 10);
            $table->string('chadditionr', 10);
            $table->string('chadditionl', 10);
            $table->string('chaxisr', 10);
            $table->string('chaxisl', 10);
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
            $table->foreign('member_id')->references('id')->on('mmember');
            //$table->index(['kode', 'nama', 'email', 'tgllahir']);
            $table->unique(['noresep', 'tglresep']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tresep');
    }
};
