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
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('nomor_registrasi');
            $table->string('nomor_bmn');
            $table->string('jenis_barang');
            $table->string('merek');
            $table->string('type');
            $table->string('kondisi');
            $table->date('pemeliharaan_terakhir');
            $table->date('tanggal_penerimaan');
            $table->integer('jumlah');
            $table->string('sumber');
            $table->integer('no_urut')->unique();  // Kolom no_urut
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
