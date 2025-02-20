<?php

// app/Models/RiwayatPerubahanKondisi.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPerubahanKondisi extends Model
{
    use HasFactory;

    protected $table = 'riwayat_perubahan_kondisi'; // Menentukan nama tabel

    protected $fillable = [
        'inventaris_id',
        'kondisi_lama',
        'kondisi_baru',
        'tanggal_perubahan'
    ];

    // Relasi dengan Inventaris
    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class, 'inventaris_id');
    }
}


