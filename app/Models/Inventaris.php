<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Inventaris extends Model
{
    protected $fillable = [
        'nama_barang',
        'nomor_registrasi',
        'nomor_bmn',
        'jenis_barang',
        'merek',
        'type',
        'kondisi',
        'pemeliharaan_terakhir',
        'tanggal_penerimaan',
        'jumlah',
        'sumber',
    ];

    public $timestamps = true; // Pastikan timestamps diaktifkan jika perlu
    
    public function getHashidAttribute()
    {
        return Hashids::encode($this->id);
    }

    // Menambahkan aturan auto increment untuk no_urut
    //protected $primaryKey = 'no_urut'; 
}
