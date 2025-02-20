<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatPerubahanKondisiTable extends Migration
{
    public function up()
    {
        Schema::create('riwayat_perubahan_kondisi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventaris_id');
            $table->string('kondisi_lama');
            $table->string('kondisi_baru');
            $table->timestamp('tanggal_perubahan');
            $table->timestamps();

            $table->foreign('inventaris_id')->references('id')->on('inventaris')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('riwayat_perubahan_kondisi');
    }
}


