<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintPermintaan extends Model
{
    use HasFactory;

    protected $table = 'print_permintaan';
    
    protected $fillable = ['peminta', 'tanggal', 'arrayPrint'];

    protected $casts = [
        'arrayPrint' => 'array', // Otomatis decode JSON ke array saat diakses
    ];
}
