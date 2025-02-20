@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Stok Barang</h2>
    
    <button class="btn btn-primary" onclick="tambahBarang()">Tambah Stok Barang</button>
    
    <table id="stok-barang" class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Satuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stokBarang as $barang)
            <tr>
                <td>{{ $barang->nama_barang }}</td>
                <td>
                    <input type="number" id="stok-{{ $barang->id }}" value="{{ $barang->stok }}" min="0" class="form-control" />
                </td>
                <td>{{ $barang->satuan }}</td>
                <td>
                    <button class="btn btn-warning" onclick="updateStok({{ $barang->id }})">Update Stok</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#stok-barang').DataTable();
    });

    function tambahBarang() {
        Swal.fire({
            title: "Tambah Stok Barang",
            html: `
                <input id="nama_barang" class="swal2-input" placeholder="Nama Barang">
                <input id="stok" type="number" class="swal2-input" placeholder="Stok" min="1">
                <select id="satuan" class="swal2-input">
                    <option value="Biji">Biji</option>
                    <option value="Lembar">Lembar</option>
                    <option value="Pak">Pak</option>
                    <option value="Dus">Dus</option>
                    <option value="Rim">Rim</option>
                    <option value="Lusin">Lusin</option>
                </select>
            `,
            showCancelButton: true,
            confirmButtonText: "Tambah",
            cancelButtonText: "Batal",
            preConfirm: () => {
                let nama_barang = document.getElementById("nama_barang").value;
                let stok = document.getElementById("stok").value;
                let satuan = document.getElementById("satuan").value;

                if (!nama_barang || !stok || !satuan) {
                    Swal.showValidationMessage("Semua field wajib diisi!");
                }

                return { nama_barang, stok, satuan };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ route('stok.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(result.value)
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire("Sukses!", data.success, "success").then(() => {
                        location.reload();
                    });
                })
                .catch(error => {
                    Swal.fire("Error!", "Terjadi kesalahan!", "error");
                });
            }
        });
    }

    function updateStok(id) {
        let stok = document.getElementById(`stok-${id}`).value;

        if (stok < 0) {
            Swal.fire("Error!", "Stok tidak boleh kurang dari 0!", "error");
            return;
        }

        fetch("{{ route('stok.update') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ id, stok })
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire("Sukses!", data.success, "success");
        })
        .catch(error => {
            Swal.fire("Error!", "Terjadi kesalahan!", "error");
        });
    }
</script>
@endsection
