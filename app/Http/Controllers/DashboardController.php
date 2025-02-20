<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PencatatanNomor;
use App\Models\StokBarang;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Data surat dalam 1 bulan terakhir
        $bulanIni = Carbon::now()->format('Y-m');
        $suratBulanan = PencatatanNomor::where('tanggal', 'like', "$bulanIni%")->count();

        // Dapatkan nomor surat terakhir yang diminta
        $lastNumber = PencatatanNomor::latest()->first()?->nomor_surat ?? 0;


        // Data stok barang
        $stokBarang = StokBarang::all();

        // Notifikasi stok menipis (jika < 10)
        $stokMenipis = StokBarang::where('stok', '<', 10)->get();

        return view('dashboard', compact('suratBulanan', 'lastNumber', 'stokBarang', 'stokMenipis'));
    }
}
