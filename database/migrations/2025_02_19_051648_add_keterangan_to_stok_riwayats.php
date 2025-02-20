<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('stok_riwayats', function (Blueprint $table) {
            $table->string('keterangan')->nullable()->after('jumlah');
        });
    }
    
    public function down()
    {
        Schema::table('stok_riwayats', function (Blueprint $table) {
            $table->dropColumn('keterangan');
        });
    }
};
