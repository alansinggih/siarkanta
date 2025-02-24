@php
    use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts.app')
@section('css')
<style>
    .td-container {
        display: flex;
        align-items: center;
        gap: 10px; /* Jarak antar elemen */
    }

    .td-container select {
        width: 75%;
    }

    .td-container input {
        width: 25%;
    }
</style>
@endsection

@section('content')
<div class="container">
    <h3 class="mb-4">Form Permintaan ATK</h3>

    <form action="{{ route('atk.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Bagian / Bidang</label>
            @if(Auth::user()->role === 'atk')
                <input type="text" class="form-control" name="bagian" value="{{ Auth::user()->name }}" readonly required>
            @else
                <select class="form-control" name="bagian" required>
                    <option value="">-- Pilih Bagian --</option>
                    <option value="Umum">Umum</option>
                    <option value="Keuangan">Keuangan</option>
                    <option value="Binadik">Binadik</option>
                    <option value="Registrasi">Registrasi</option>
                    <option value="Bimkemaswat">Bimkemaswat</option>
                    <option value="KPLP">KPLP</option>
                    <option value="Kamtib">Kamtib</option>
                </select>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" class="form-control" name="tanggal" required>
        </div>

        <button type="button" class="btn btn-success mb-3" id="addRow">Tambah Barang</button>

        <table class="table table-bordered" id="atkTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td class="td-container">
                        <div class="d-flex align-items-center gap-2">
                            <select class="form-select nama-barang" name="nama_barang[]" required>
                                <option value="">Pilih Barang</option>
                                @foreach($stokBarangs as $barang)
                                    <option value="{{ $barang->id }}" data-stok="{{ $barang->stok }}" data-satuan="{{ $barang->satuan }}">
                                        {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                                    </option>
                                @endforeach
                            </select>
                            <input type="text" class="form-control satuan" name="satuan[]" readonly>
                        </div>
                    </td>
                    <td>
                        <input type="number" class="form-control jumlah" name="jumlah[]" min="1" required>
                        <small class="text-danger stok-warning" style="display: none;">Stok tidak mencukupi!</small>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-row" style="display: none;">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary btn-Simpan">Simpan</button>
        <input type="button" value="Lihat" id="exportPdfBtn" class="btn btn-primary btn-Simpan"\>

    </form>
</div>
<!-- Modal Preview PDF -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">Preview PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="pdfFrame" src="" style="width: 100%; height: 500px;" frameborder="0"></iframe>
            </div>
            <div class="modal-footer">
                <a id="exportPDF" href="#" class="btn btn-danger">Download PDF</a>
                <button type="button" class="btn btn-primary" id="printPDF">Print</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
$(document).ready(function() {

    $("#printPDF").click(function () {
        let iframe = document.getElementById("pdfFrame").contentWindow;
        iframe.focus();
        iframe.print(); // Memanggil window.print() di dalam iframe
    });

    $('.btn-Simpan').click(function(){
       // $("select, input").prop('disabled', 'disabled');;
    })
    // export pdf
    $("#exportPDF").click(function() {
        let barangData = [];

        // Ambil data dari tabel
        $("#atkTable tbody tr").each(function() {
            let namaBarang = $(this).find(".nama-barang option:selected").text().trim();
            let satuan = $(this).find(".satuan").val();
            let jumlah = $(this).find(".jumlah").val();
            let namaBarang1 = namaBarang.split("(")[0];

            barangData.push({
                nama_barang: namaBarang1,
                satuan: satuan,
                jumlah: jumlah
            });
        });

        // Ambil data bagian dan tanggal
        let bagian = $("input[name='bagian']").val() || $("select[name='bagian']").val();
        let tanggalInput = $("input[name='tanggal']").val();
        let tanggalFormatted = formatTanggal(tanggalInput);


        // Encode data ke URL dan arahkan ke halaman export
        let url = "{{ route('export.pdfFile') }}?barang=" + encodeURIComponent(JSON.stringify(barangData)) + 
              "&bagian=" + encodeURIComponent(bagian) + 
              "&tanggal=" + encodeURIComponent(tanggalFormatted);
        window.location.href = url;
    });

    $("#exportPdfBtn").click(function() {
        // Ambil semua data barang dari tabel
        let barang = [];
        $("#atkTable tbody tr").each(function() {
            let nama = $(this).find(".nama-barang option:selected").text().trim(); // Hapus (Stok: xx)
            let satuan = $(this).find(".satuan").val();
            let jumlah = $(this).find(".jumlah").val();
            let nama1 = nama.split("(")[0];
            
            if (nama1 && satuan && jumlah) {
                barang.push({ nama_barang: nama1, satuan: satuan, jumlah: jumlah });
            }
        });

        if (barang.length === 0) {
            alert("Pilih minimal satu barang!");
            return;
        }
        // Ambil data bagian dan tanggal
        let bagian = $("input[name='bagian']").val() || $("select[name='bagian']").val();
        let tanggalInput = $("input[name='tanggal']").val();
        let tanggalFormatted = formatTanggal(tanggalInput);

        // Encode barang ke URL parameter
        let barangJson = encodeURIComponent(JSON.stringify(barang)) + 
              "&bagian=" + encodeURIComponent(bagian) + 
              "&tanggal=" + encodeURIComponent(tanggalFormatted);
        let pdfUrl = "{{ getBaseUrl() }}/export-pdf?barang=" + barangJson;

        // Tampilkan preview PDF di modal
        $("#pdfFrame").attr("src", pdfUrl); // Download PDF setelah preview
        $("#previewModal").modal("show");
    });

    // Tambah Baris Baru
    $("#addRow").click(function() {
        let rowCount = $("#atkTable tbody tr").length + 1;
        let newRow = `
            <tr>
                <td>${rowCount}</td>
                <td class="td-container">
                    <div class="d-flex align-items-center gap-2">
                        <select name="nama_barang[]" class="form-control nama-barang" required>
                            <option value="">Pilih Barang</option>
                            @foreach($stokBarangs as $barang)
                                <option value="{{ $barang->id }}" data-stok="{{ $barang->stok }}" data-satuan="{{ $barang->satuan }}">
                                    {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                                </option>
                            @endforeach
                        </select>
                        <input type="text" name="satuan[]" class="form-control satuan" readonly>
                    </div>
                </td>
                <td>
                    <input type="number" name="jumlah[]" class="form-control jumlah" min="1" required>
                    <small class="text-danger stok-warning" style="display: none;">Stok tidak mencukupi!</small>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
                </td>
            </tr>
        `;
        $("#atkTable tbody").append(newRow);
        updateDeleteButtons();
    });

    // Hapus Baris dengan SweetAlert2
    $(document).on("click", ".remove-row", function() {
        let row = $(this).closest("tr");
        Swal.fire({
            title: "Hapus Baris?",
            text: "Apakah Anda yakin ingin menghapus baris ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                row.remove();
                updateRowNumbers();
                updateDeleteButtons();
            }
        });
    });

    // Update Nomor Baris
    function updateRowNumbers() {
        $("#atkTable tbody tr").each(function(index) {
            $(this).find("td:first").text(index + 1);
        });
    }

    // Sembunyikan tombol hapus jika hanya ada 1 baris
    function updateDeleteButtons() {
        if ($("#atkTable tbody tr").length === 1) {
            $(".remove-row").hide();
        } else {
            $(".remove-row").show();
        }
    }

    // Cek Stok Saat Input Jumlah
    $(document).on("input", ".jumlah", function() {
        let row = $(this).closest("tr");
        let stokTersedia = row.find(".nama-barang option:selected").data("stok");
        let jumlahDiminta = $(this).val();
        let warning = row.find(".stok-warning");

        if (jumlahDiminta > stokTersedia) {
            warning.show();
            $(this).val(stokTersedia); // Batasi ke stok tersedia
        } else {
            warning.hide();
        }
    });

    // Update Satuan Saat Barang Dipilih
    $(document).on("change", ".nama-barang", function() {
        let row = $(this).closest("tr");
        let satuanInput = row.find(".satuan");
        let satuan = $(this).find(":selected").data("satuan"); // Ambil satuan dari data-satuan
        satuanInput.val(satuan);
    });

    // Jalankan saat pertama kali halaman dimuat
    updateDeleteButtons();

    //fungsi tanggal
        // Fungsi untuk format tanggal ke: 21 Februari 2025
    function formatTanggal(dateString) {
        if (!dateString) return "";
        let months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        let date = new Date(dateString);
        let day = date.getDate();
        let month = months[date.getMonth()];
        let year = date.getFullYear();
        return `${day} ${month} ${year}`;
    }
});
</script>
@endsection
