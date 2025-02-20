@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detail Inventaris</h1>
        <table class="table table-bordered">
            <tr>
                <th>No Urut</th>
                <td>{{ $inventaris->no_urut }}</td>
            </tr>
            <tr>
                <th>Nama Barang</th>
                <td>{{ $inventaris->nama_barang }}</td>
            </tr>
            <tr>
                <th>Nomor Registrasi</th>
                <td>{{ $inventaris->nomor_registrasi }}</td>
            </tr>
            <tr>
                <th>Nomor BMN</th>
                <td>{{ $inventaris->nomor_bmn }}</td>
            </tr>
            <tr>
                <th>Jenis Barang</th>
                <td>{{ $inventaris->jenis_barang }}</td>
            </tr>
            <tr>
                <th>Merek</th>
                <td>{{ $inventaris->merek }}</td>
            </tr>
            <tr>
                <th>Tipe</th>
                <td>{{ $inventaris->type }}</td>
            </tr>
            <tr>
                <th>Kondisi</th>
                <td>{{ $inventaris->kondisi }}</td>
            </tr>
            <tr>
                <th>Pemeliharaan Terakhir</th>
                <td>{{ $inventaris->pemeliharaan_terakhir }}</td>
            </tr>
            <tr>
                <th>Tanggal Penerimaan</th>
                <td>{{ $inventaris->tanggal_penerimaan }}</td>
            </tr>
            <tr>
                <th>Jumlah</th>
                <td>{{ $inventaris->jumlah }}</td>
            </tr>
            <tr>
                <th>Sumber</th>
                <td>{{ $inventaris->sumber }}</td>
            </tr>
        </table>

        <a href="{{ route('inventaris.index') }}" class="btn btn-primary">Kembali ke Daftar Inventaris</a>
    </div>
@endsection
