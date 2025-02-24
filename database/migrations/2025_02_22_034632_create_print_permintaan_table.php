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
        Schema::create('print_permintaan', function (Blueprint $table) {
            $table->id();
            $table->string('peminta'); // Nama peminta ATK
            $table->date('tanggal'); // Tanggal permintaan
            $table->json('arrayPrint'); // Data barang dalam format JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('print_permintaan');
    }
};
