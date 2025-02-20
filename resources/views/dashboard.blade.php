@extends('layouts.app') 

@section('content')
<div class="container">
    <h2 class="mb-4">Dashboard SIARKANTA</h2>

    <div class="row">
        <!-- Card Permintaan Surat Bulan Ini -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa-solid fa-envelope"></i> Permintaan Surat Bulan Ini</h5>
                    <p class="card-text display-4">{{ $suratBulanan }}</p>
                </div>
            </div>
        </div>

        <!-- Card Nomor Surat Terakhir -->
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa-solid fa-list-ol"></i> Nomor Surat Terakhir</h5>
                    <p class="card-text display-4">{{ $lastNumber }}</p>
                </div>
            </div>
        </div>

        <!-- Card Stok Barang -->
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa-solid fa-box"></i> Total Stok ATK</h5>
                    <ul class="list-group">
                        @foreach($stokBarang as $barang)
                        <li class="list-group-item d-flex justify-content-between">
                            {{ $barang->nama_barang }} <span>{{ $barang->stok }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Card Barang Stok Menipis -->
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa-solid fa-triangle-exclamation"></i> Barang Stok Menipis</h5>
                    <ul class="list-group">
                        @foreach($stokMenipis as $barang)
                        <li class="list-group-item d-flex justify-content-between">
                            {{ $barang->nama_barang }} <span>{{ $barang->stok }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
