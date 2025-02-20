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
        Schema::create('stok_riwayats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi dengan tabel users
            $table->foreignId('stok_barang_id')->constrained('stok_barangs')->onDelete('cascade'); // Relasi dengan stok_barangs
            $table->enum('aksi', ['tambah', 'kurangi','tambah barang baru']); // Aksi yang dilakukan
            $table->integer('jumlah'); // Jumlah yang ditambah atau dikurangi
            $table->timestamps(); // Waktu aksi dilakukan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_riwayats');
    }
};
