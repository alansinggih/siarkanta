@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Inventaris Barang</h2>

    <!-- Button Tambah Barang -->
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInventarisModal">Tambah Barang</button>

    <!-- Tabel Inventaris -->
    <table class="table mt-3">
        <thead>
            <tr>
                <th>No Urut</th>
                <th>Nama Barang</th>
                <th>Nomor Registrasi</th>
                <th>Kondisi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventaris as $item)
            <tr>
                <td>{{ $item->no_urut }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->nomor_registrasi }}</td>
                <td>{{ $item->kondisi }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editInventarisModal{{ $item->id }}">Edit</button>
                    <a href="{{ route('inventaris.show', $item->hashid) }}" class="btn btn-info">Detail</a>
                </td>
            </tr>

            <!-- Modal Edit Inventaris -->
            <div class="modal fade" id="editInventarisModal{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog">
                <form action="{{ route('inventaris.update', $item->id) }}" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Inventaris</h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="kondisi" class="form-label">Kondisi:</label>
                                <select id="kondisi" class="form-select" name="kondisi">
                                    <option value="Baik" {{ $item->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Rusak Sebagian" {{ $item->kondisi == 'Rusak Sebagian' ? 'selected' : '' }}>Rusak Sebagian</option>
                                    <option value="Rusak Parah" {{ $item->kondisi == 'Rusak Parah' ? 'selected' : '' }}>Rusak Parah</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_pemeliharaan" class="form-label">Tanggal Pemeliharaan Terakhir:</label>
                                <input type="date" id="tanggal_pemeliharaan" class="form-control" name="tanggal_pemeliharaan" value="{{ $item->pemeliharaan_terakhir }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>

                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Barang -->
<div class="modal fade" id="addInventarisModal" tabindex="-1" aria-labelledby="addInventarisModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <form action="{{ route('inventaris.store') }}" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInventarisModalLabel">Tambah Inventaris Barang</h5>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang:</label>
                    <input type="text" id="nama_barang" class="form-control" name="nama_barang" required>
                </div>
                <div class="mb-3">
                    <label for="nomor_registrasi" class="form-label">Nomor Registrasi:</label>
                    <input type="text" id="nomor_registrasi" class="form-control" name="nomor_registrasi" required>
                </div>
                <div class="mb-3">
                    <label for="nomor_bmn" class="form-label">Nomor BMN:</label>
                    <input type="text" id="nomor_bmn" class="form-control" name="nomor_bmn" required>
                </div>
                <div class="mb-3">
                    <label for="jenis_barang" class="form-label">Jenis Barang:</label>
                    <input type="text" id="jenis_barang" class="form-control" name="jenis_barang" required>
                </div>
                <div class="mb-3">
                    <label for="merek" class="form-label">Merek:</label>
                    <input type="text" id="merek" class="form-control" name="merek" required>
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Type:</label>
                    <input type="text" id="type" class="form-control" name="type" required>
                </div>
                <div class="mb-3">
                    <label for="kondisi" class="form-label">Kondisi:</label>
                    <select id="kondisi" class="form-select" name="kondisi" required>
                        <option value="Baik">Baik</option>
                        <option value="Rusak Sebagian">Rusak Sebagian</option>
                        <option value="Rusak Parah">Rusak Parah</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="pemeliharaan_terakhir" class="form-label">Pemeliharaan Terakhir:</label>
                    <input type="date" id="pemeliharaan_terakhir" class="form-control" name="pemeliharaan_terakhir" required>
                </div>
                <div class="mb-3">
                    <label for="tanggal_penerimaan" class="form-label">Tanggal Penerimaan:</label>
                    <input type="date" id="tanggal_penerimaan" class="form-control" name="tanggal_penerimaan" required>
                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah:</label>
                    <input type="number" id="jumlah" class="form-control" name="jumlah" required>
                </div>
                <div class="mb-3">
                    <label for="sumber" class="form-label">Sumber:</label>
                    <input type="text" id="sumber" class="form-control" name="sumber" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </form>
    </div>
</div>

@endsection
