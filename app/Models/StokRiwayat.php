<?php

// app/Models/StokRiwayat.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class StokRiwayat extends Model
{
    use HasFactory;

    protected $table = 'stok_riwayats';

    protected $fillable = [
        'user_id',
        'stok_barang_id',
        'aksi',
        'jumlah',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stokBarang()
    {
        return $this->belongsTo(StokBarang::class);
    }

    public function getHashidAttribute()
    {
        return \Hashids::encode($this->id);
    }
}
