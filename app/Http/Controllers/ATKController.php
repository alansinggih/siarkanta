<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokBarang;
use App\Models\StokRiwayat;
use App\Models\PrintPermintaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;


class ATKController extends Controller {
    public function index() {
        $stokBarangs = StokBarang::all();
        return view('atk.form', compact('stokBarangs'));
    }

    public function store(Request $request) {
        //dd($request->all());
        $request->validate([
            'nama_barang' => 'required|array',
            'satuan' => 'required|array',
            'jumlah' => 'required|array|min:1',
            'bagian'=>'required|string',
        ]);

        foreach ($request->nama_barang as $index => $idBarang) {
            $barang = StokBarang::find($idBarang);
            $jumlah = $request->jumlah[$index];
            $bagian = $request->input('bagian', 'Tidak Diketahui');

            if (!$barang || !$barang->kurangiStok($jumlah)) {
                return back()->with('error', "Stok barang '{$barang->nama_barang}' tidak cukup!");
            }
                    // Simpan ke stok_riwayats
            StokRiwayat::create([
                'user_id' => Auth::id(),
                'stok_barang_id' => $barang->id,
                'aksi' => "request", // Tambahkan aksi default
                'jumlah' => abs($jumlah),
                'keterangan' => Auth::user()->name . " telah memberikan {$jumlah} {$barang->satuan} kepada {$bagian} melalui Form Permintaan ATK. Sisa stok: {$barang->stok} {$barang->satuan}.",
            ]);

        }

        PrintPermintaan::create([
            'peminta' => $request->input('bagian'),
            'tanggal' => now()->toDateString(),
            'arrayPrint' => json_encode(array_map(function ($id, $index) use ($request) {
                return [
                    'nama_barang' => StokBarang::find($id)->nama_barang ?? 'Tidak Diketahui',
                    'satuan' => $request->satuan[$index] ?? '-',
                    'jumlah' => $request->jumlah[$index] ?? 0,
                ];
            }, $request->nama_barang, array_keys($request->nama_barang))),
        ]);

        return back()->with('success', 'Permintaan ATK berhasil disimpan!');
    }

    public function exportPDF(Request $request) {
        // Ambil data barang dari parameter GET
        $barang = json_decode($request->query('barang'), true);
        $bagian = $request->query('bagian', 'Tidak Diketahui');
        $tanggal = $request->query('tanggal', date('d F Y'));
    
        // Cek apakah ada data barang
        if (!$barang) {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }
        //Pdf::setPaper('A4', 'portrait')->setOption(['dpi' => 150,'defaultFont' => 'Arial',]);
        // Load PDF dengan data dari GET request
        //$pdf = Pdf::loadView('pdf.permintaan_atk', compact('barang'));
        return view('pdf.permintaan_atk', compact('barang', 'bagian', 'tanggal'));
        //return $pdf->download('form-permintaan-atk.pdf');
    }
    
    
    public function exportPDFFile(Request $request) {
        // Ambil data barang dari parameter GET
        $barang = json_decode($request->query('barang'), true);
        $bagian = $request->query('bagian', 'Tidak Diketahui');
        $tanggal = $request->query('tanggal', date('d F Y'));
    
        // Cek apakah ada data barang
        if (!$barang) {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }
        // Load PDF dengan data dari GET request
        $pdf = Pdf::loadView('pdf.permintaan_atk', compact('barang', 'bagian', 'tanggal'));
        //return view('pdf.permintaan_atk', compact('barang'));
        return $pdf -> setPaper('A4', 'portrait')->setOption(['dpi' => 150,'defaultFont' => 'sans-serif',])->download('Permintaan ATK.pdf');
    }
    
    public function printPermintaan() {
        $data = PrintPermintaan::latest()->get(); // Ambil semua data permintaan ATK terbaru
    
        return view('atk.riwayat_print', compact('data'));
    }
    
}
