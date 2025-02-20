<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('stok_barangs', function (Blueprint $table) {
            $table->dropColumn('barcode'); // Hapus kolom barcode
            $table->string('satuan')->after('stok'); // Tambah kolom satuan
        });
    }

    public function down()
    {
        Schema::table('stok_barangs', function (Blueprint $table) {
            $table->string('barcode')->nullable(); // Kembalikan barcode jika rollback
            $table->dropColumn('satuan'); // Hapus kolom satuan jika rollback
        });
    }
};

