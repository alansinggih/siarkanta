@extends('layouts.app')

@section('content')
<?php
     $currentUrl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
     $split = explode("/",$currentUrl)[3];
     $url = $split == "siarkanta" ? "/siarkanta" :"";
    ?>
<div class="container">
    <h3>Pencatatan Nomor Surat</h3>
    <p>Nomor Surat Terakhir: <strong id="last-number">{{ $lastNumber }}</strong></p>
    
    <button class="btn btn-primary mb-3" id="addNomorBtn">Tambah Nomor Surat</button>

    <table class="table table-bordered" id="nomorTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Surat</th>
                <th>Keperluan</th>
                <th>Peminta</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nomorsurat as $index => $nomor)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $nomor->nomor_surat }}</td>
                    <td>{{ $nomor->keperluan }}</td>
                    <td>{{ $nomor->peminta }}</td>
                    <td>{{ $nomor->tanggal }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm editNomorBtn" data-id="{{ $nomor->id }}" 
                            data-keperluan="{{ $nomor->keperluan }}" 
                            data-peminta="{{ $nomor->peminta }}"
                            data-tanggal="{{ $nomor->tanggal }}">Edit</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        $('#nomorTable').DataTable();

        $('#addNomorBtn').click(function () {
            Swal.fire({
                title: 'Tambah Nomor Surat',
                html:
                    '<input id="keperluan" class="swal2-input" placeholder="Keperluan">' +
                    '<input id="peminta" class="swal2-input" placeholder="Peminta">' +
                    '<input type="date" id="tanggal" class="swal2-input">',
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                preConfirm: () => {
                    let keperluan = $('#keperluan').val();
                    let peminta = $('#peminta').val();
                    let tanggal = $('#tanggal').val();
                    if (!keperluan || !peminta || !tanggal) {
                        Swal.showValidationMessage('Semua bidang harus diisi!');
                    }
                    return { keperluan, peminta, tanggal };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('pencatatan.nomor.store') }}",
                        method: "POST",
                        data: {
                            keperluan: result.value.keperluan,
                            peminta: result.value.peminta,
                            tanggal: result.value.tanggal,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            Swal.fire('Sukses!', response.success, 'success').then(() => location.reload());
                        }
                    });
                }
            });
        });

        $('.editNomorBtn').click(function () {
            let id = $(this).data('id');
            let keperluan = $(this).data('keperluan');
            let peminta = $(this).data('peminta');
            let tanggal = $(this).data('tanggal');

            Swal.fire({
                title: 'Edit Nomor Surat',
                html:
                    `<input id="editKeperluan" class="swal2-input" value="${keperluan}">` +
                    `<input id="editPeminta" class="swal2-input" value="${peminta}">` +
                    `<input type="date" id="editTanggal" class="swal2-input" value="${tanggal}">`,
                showCancelButton: true,
                confirmButtonText: 'Update',
                preConfirm: () => {
                    return {
                        keperluan: $('#editKeperluan').val(),
                        peminta: $('#editPeminta').val(),
                        tanggal: $('#editTanggal').val(),
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo $url; ?>/nomor-surat/" + id,
                        method: "PUT",
                        data: {
                            keperluan: result.value.keperluan,
                            peminta: result.value.peminta,
                            tanggal: result.value.tanggal,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            Swal.fire('Sukses!', response.success, 'success').then(() => location.reload());
                        }
                    });
                }
            });
        });
    });
</script>

@endsection
