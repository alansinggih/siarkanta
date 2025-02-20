<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PencatatanNomor;

class PencatatanNomorController extends Controller
{
    public function index()
    {
        $nomorsurat = PencatatanNomor::latest()->get();
        $lastNumber = PencatatanNomor::latest()->first()?->nomor_surat ?? 0;

        return view('pencatatan_nomor.index', compact('nomorsurat', 'lastNumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keperluan' => 'required|string',
            'peminta' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $lastNumber = PencatatanNomor::latest()->first()?->nomor_surat ?? 0;
        $newNumber = $lastNumber + 1;

        PencatatanNomor::create([
            'nomor_surat' => $newNumber,
            'keperluan' => $request->keperluan,
            'peminta' => $request->peminta,
            'tanggal' => $request->tanggal,
            'user_id' => auth()->id(),
        ]);

        return response()->json(['success' => 'Nomor surat berhasil ditambahkan!']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'keperluan' => 'required|string',
            'peminta' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $nomor = PencatatanNomor::findOrFail($id);
        $nomor->update([
            'keperluan' => $request->keperluan,
            'peminta' => $request->peminta,
            'tanggal' => $request->tanggal,
        ]);

        return response()->json(['success' => 'Nomor surat berhasil diperbarui!']);
    }
}
