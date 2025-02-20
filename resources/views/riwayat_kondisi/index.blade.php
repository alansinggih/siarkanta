@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Perubahan Kondisi</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Barang</th>
                <th>Kondisi</th>
                <th>Tanggal Pemeliharaan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayat as $key => $r)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $r->inventaris->nama_barang ?? 'Unknown' }}</td>
                    <td>{{ ucfirst($r->kondisi_baru) }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->tanggal_perubahan)->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
