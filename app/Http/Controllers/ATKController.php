<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokBarang;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ATKController extends Controller {
    public function index() {
        $stokBarangs = StokBarang::all();
        return view('atk.form', compact('stokBarangs'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_barang' => 'required|array',
            'satuan' => 'required|array',
            'jumlah' => 'required|array|min:1',
        ]);

        foreach ($request->nama_barang as $index => $idBarang) {
            $barang = StokBarang::find($idBarang);
            $jumlah = $request->jumlah[$index];

            if (!$barang || !$barang->kurangiStok($jumlah)) {
                return back()->with('error', "Stok barang '{$barang->nama_barang}' tidak cukup!");
            }
        }

        return back()->with('success', 'Permintaan ATK berhasil disimpan!');
    }

    public function exportPDF(Request $request) {
        // Ambil data barang dari parameter GET
        $barang = json_decode($request->query('barang'), true);
    
        // Cek apakah ada data barang
        if (!$barang) {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }
        Pdf::setPaper('A4', 'portrait')->setOption(['dpi' => 150,'defaultFont' => 'Arial',]);
        // Load PDF dengan data dari GET request
        //$pdf = Pdf::loadView('pdf.permintaan_atk', compact('barang'));
        return view('pdf.permintaan_atk', compact('barang'));
        //return $pdf->download('form-permintaan-atk.pdf');
    }
    
    
    public function exportPDFFile(Request $request) {
        // Ambil data barang dari parameter GET
        $barang = json_decode($request->query('barang'), true);
    
        // Cek apakah ada data barang
        if (!$barang) {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }
        // Load PDF dengan data dari GET request
        $pdf = Pdf::loadView('pdf.permintaan_atk', compact('barang'));
        //return view('pdf.permintaan_atk', compact('barang'));
        return $pdf -> setPaper('A4', 'portrait')->setOption(['dpi' => 150,'defaultFont' => 'sans-serif',])->download('Permintaan ATK.pdf');
    }

    public function printPermintaan()
    {
        // Ambil data permintaan ATK dari database
        $permintaanATK = PermintaanATK::all(); // Sesuaikan dengan model dan metode yang digunakan untuk mengambil data

        // Mengembalikan view dengan data yang diperlukan untuk dicetak
        return view('permintaan_atk.print', compact('permintaanATK'));
    }

    
}
