@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Print Permintaan ATK</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Peminta</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $data->peminta }}</td>
                <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d F Y') }}</td>
                <td>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDetail"
                        onclick="showDetail({{ json_encode($data) }})">
                        Detail
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- Modal Preview PDF -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
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
    function showDetail(data) {
        let tanggal = formatTanggal(data.tanggal);
        let printURL = "{{ url('/export-pdf') }}" + 
            `?barang=${encodeURIComponent(data.arrayPrint)}` + 
            `&bagian=${encodeURIComponent(data.peminta)}` + 
            `&tanggal=${encodeURIComponent(tanggal)}`;

        let downloadURL = "{{ route('export.pdfFile') }}" + 
            `?barang=${encodeURIComponent(data.arrayPrint)}` + 
            `&bagian=${encodeURIComponent(data.peminta)}` + 
            `&tanggal=${encodeURIComponent(tanggal)}`;
        // Set URL ke iframe untuk menampilkan preview PDF
        $("#pdfFrame").attr("src", printURL);

        // Set URL tombol Download PDF
        $("#exportPDF").attr("href", downloadURL);

        // Tombol Print PDF membuka file di tab baru
        $("#printPDF").off("click").on("click", function () {
            console.log("Print Preview");
            let iframe = document.getElementById("pdfFrame").contentWindow;
            iframe.focus();
            iframe.print();
        });
    }

        // Reset modal saat ditutup agar iframe kosong
    $("#modalDetail").on("hidden.bs.modal", function () {
        $("#pdfFrame").attr("src", ""); // Hapus sumber PDF agar modal benar-benar kosong
    });

    function formatTanggal(dateString) {
        if (!dateString) return "";
        let months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        let date = new Date(dateString);
        let day = date.getDate();
        let month = months[date.getMonth()];
        let year = date.getFullYear();
        return `${day} ${month} ${year}`;
    }
</script>
@endsection
