<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatPerubahanKondisi;
use App\Models\Inventaris;

class RiwayatKondisiController extends Controller
{
    public function index()
    {
        $riwayat = RiwayatPerubahanKondisi::with('inventaris')->orderBy('tanggal_perubahan', 'desc')->get();
        return view('riwayat_kondisi.index', compact('riwayat'));
    }
}
