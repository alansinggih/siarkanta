<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PencatatanNomor extends Model
{
    use HasFactory;

    protected $fillable = ['nomor_surat', 'keperluan', 'peminta', 'tanggal', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
