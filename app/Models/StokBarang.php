<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    use HasFactory;

    protected $table = 'stok_barangs';
    protected $fillable = ['nama_barang', 'stok', 'satuan'];

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class, 'nama_barang', 'nama_barang');
    }
}
