<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventaris;
use App\Models\RiwayatPerubahanKondisi;
use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;

class InventarisController extends Controller
{
    public function index()
    {
        $inventaris = Inventaris::all();
        return view('inventaris.index', compact('inventaris'));
    }

    public function store(Request $request)
    {
        // Mencari nilai no_urut terakhir
        $lastInventaris = Inventaris::orderBy('no_urut', 'desc')->first();
        $newNoUrut = $lastInventaris ? $lastInventaris->no_urut + 1 : 1; // Jika tidak ada data sebelumnya, mulai dari 1
    
        // Membuat data inventaris baru
        $inventaris = new Inventaris();
        $inventaris->nama_barang = $request->nama_barang;
        $inventaris->nomor_registrasi = $request->nomor_registrasi;
        $inventaris->nomor_bmn = $request->nomor_bmn;
        $inventaris->jenis_barang = $request->jenis_barang;
        $inventaris->merek = $request->merek;
        $inventaris->type = $request->type;
        $inventaris->kondisi = $request->kondisi;
        $inventaris->pemeliharaan_terakhir = $request->pemeliharaan_terakhir;
        $inventaris->tanggal_penerimaan = $request->tanggal_penerimaan;
        $inventaris->jumlah = $request->jumlah;
        $inventaris->sumber = $request->sumber;
        $inventaris->no_urut = $newNoUrut; // Menambahkan no_urut otomatis
        $inventaris->save();
    
        return redirect()->route('inventaris.index')->with('success', 'Inventaris berhasil ditambahkan!');
    }
    

    public function update(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'id' => 'required|integer|exists:inventaris,id',
            'kondisi' => 'required|string',
            'tanggal_pemeliharaan' => 'required|date',
        ]);

        // Cari data inventaris berdasarkan ID
        $inventaris = Inventaris::findOrFail($request->id);

        // Simpan kondisi lama sebelum di-update
        $kondisiLama = $inventaris->kondisi;

        // Update data inventaris
        $inventaris->update([
            'kondisi' => $validated['kondisi'],
            'pemeliharaan_terakhir' => $validated['tanggal_pemeliharaan'],
        ]);

        // Jika kondisi berubah, catat ke tabel riwayat
        if ($kondisiLama !== $request->kondisi) {
            RiwayatPerubahanKondisi::create([
                'inventaris_id' => $inventaris->id,
                'kondisi_lama' => $kondisiLama,
                'kondisi_baru' => $request->kondisi,
                'tanggal_perubahan' => $validated['tanggal_pemeliharaan'],
            ]);
        }

        // Redirect dengan pesan sukses
        return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil diperbarui.');
    }

    public function show($hashid)
    {
        $id = Hashids::decode($hashid);
        
        if (empty($id)) {
            abort(404); // Kalau hashid tidak valid
        }
    
        $inventaris = Inventaris::findOrFail($id[0]); // Ambil ID pertama
    
        return view('inventaris.show', compact('inventaris'));
    }


    public function destroy(Inventaris $inventaris)
    {
        $inventaris->delete();
        return redirect()->back()->with('success', 'Data inventaris berhasil dihapus.');
    }
}

