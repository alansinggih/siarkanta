@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Perubahan Stok</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Barang</th>
                <th>Aksi</th>
                <th>Jumlah</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayat as $key => $r)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $r->user->name ?? 'Unknown' }}</td>
                    <td>{{ $r->stokBarang->nama_barang ?? 'Unknown' }}</td>
                    <td>{{ ucfirst($r->aksi) }}</td>
                    <td>{{ $r->jumlah }}</td>
                    <td>{{ $r->created_at->format('d M Y, H:i') }}</td>
                    <td>
                        <a href="{{ route('stok.detail', $r->hashid) }}" class="btn btn-info btn-sm">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
