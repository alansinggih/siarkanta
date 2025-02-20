<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokBarang;
use App\Models\StokRiwayat;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;
use Exception;

class StokBarangController extends Controller
{
    // Menampilkan seluruh data stok barang
    public function index()
    {
        $stokBarang = StokBarang::all();
        return view('stok.index', compact('stokBarang'));
    }

    // Menambahkan stok barang baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_barang' => 'required|unique:stok_barangs,nama_barang|string|max:255',
            'stok' => 'required|integer|min:1',
            'satuan' => 'required|string'
        ]);
        $aksi = 'tambah barang baru';
        // Menyimpan data stok barang baru
        $barang = StokBarang::create([
            'nama_barang' => $request->nama_barang,
            'stok' => $request->stok,
            'satuan' => $request->satuan,
        ]);

        // Pastikan user login
        if (!Auth::check()) {
            return response()->json(['error' => 'User tidak ditemukan, pastikan sudah login!'], 403);
        }
        $userName = Auth::user()->name;
        $satuan = $barang->satuan ?? 'unit';
        $namaBarang = $barang->nama_barang;

        // Buat keterangan
        $keterangan = "$userName telah menambah $namaBarang sejumlah " . abs($request->stok) . " $satuan.";

        // Simpan ke stok_riwayats
        StokRiwayat::create([
            'user_id' => Auth::id(),
            'stok_barang_id' => $barang->id,
            'aksi' => $aksi,
            'jumlah' => $request->stok,
            'keterangan' => $keterangan,
        ]);
        //dd($request->all());
    
        return response()->json(['success' => 'Barang berhasil ditambahkan dan riwayat dicatat!']);
    }

    public function update(Request $request)
    {
        //dd($request->all());
        try {
            // Validasi input
            $request->validate([
                'id' => 'required|exists:stok_barangs,id',
                'stok' => 'required|integer|min:0'
            ]);

            // Ambil data stok barang
            $stokBarang = StokBarang::findOrFail($request->id);
            $perubahanStok = $request->stok - $stokBarang->stok;
            $aksi = $perubahanStok > 0 ? 'tambah' : 'kurangi';

            // Update stok
            $stokBarang->update(['stok' => $request->stok]);

            // Pastikan user login
            if (!Auth::check()) {
                throw new Exception("User tidak ditemukan, pastikan sudah login!");
            }

            $userName = Auth::user()->name;
            $namaBarang = $stokBarang->nama_barang;
            $sisa = $stokBarang->stok;
            $satuan = $stokBarang->satuan ?? 'unit';

            if ($aksi == 'tambah') {
                $keterangan = "$userName telah menambahkan $namaBarang sejumlah " . abs($perubahanStok) . " $satuan stok barang $sisa $satuan.";
            } elseif ($aksi == 'kurangi') {
                $keterangan = "$userName telah mengambil $namaBarang sejumlah " . abs($perubahanStok) . " $satuan sisa barang $sisa $satuan.";
            }

            // Simpan ke stok_riwayats
            StokRiwayat::create([
                'user_id' => Auth::id(),
                'stok_barang_id' => $stokBarang->id,
                'aksi' => $aksi,
                'jumlah' => abs($perubahanStok),
                'keterangan' => $keterangan,
            ]);

            return response()->json(['success' => 'Stok berhasil diperbarui!']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function riwayat()
    {
        // Ambil riwayat stok dengan relasi 'user' dan 'stokBarang', urutkan berdasarkan waktu terbaru
        $riwayat = StokRiwayat::with('user', 'stokBarang')->latest()->get();

        // Kirim data riwayat ke view
        return view('stok.riwayat', compact('riwayat'));
    }

    public function detail($hashid)
    {
        // Decode hashid ke ID asli (jika pakai Hashids)
        $id = \Hashids::decode($hashid)[0] ?? null;

        // Jika ID tidak ditemukan
        if (!$id) {
            return abort(404);
        }

        // Ambil detail riwayat stok berdasarkan stok_barang_id
        $riwayat = StokRiwayat::where('id', $id)->latest()->paginate(10);

        // Kirim data ke view
        return view('stok.detail_riwayat', compact('riwayat'));
    }


}
