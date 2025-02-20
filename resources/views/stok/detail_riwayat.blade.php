@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Riwayat Stok Barang</h2>
    <table class="table table-striped">
        <tbody>
        @foreach ($riwayat as $r)
            <tr>
                <th>User</th>
                <td>{{ $r->user->name }}</td>
            </tr>
            <tr>
                <th>Aksi</th>
                <td><span class="badge bg-primary">{{ ucfirst($r->aksi) }}</span></td>
            </tr>
            <tr>
                <th>Jumlah</th>
                <td>{{ $r->jumlah }}</td>
            </tr>
            <tr>
                <th>Keterangan</th>
                <td>{{ $r->keterangan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Waktu</th>
                <td>{{ $r->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $riwayat->links() }}
    </div>
</div>
@endsection