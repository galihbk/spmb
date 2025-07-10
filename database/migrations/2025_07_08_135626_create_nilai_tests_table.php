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
          Schema::create('nilai_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ppdb_id');
            $table->float('wawancara')->default(0);
            $table->float('baca_tulis')->default(0);
            $table->float('btq')->default(0);
            $table->float('buta_warna')->default(0);
            $table->float('fisik')->default(0);
            $table->timestamps();
            $table->foreign('ppdb_id')->references('id')->on('ppdbs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_tests');
    }
};
