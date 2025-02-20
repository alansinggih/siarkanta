<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIARKANTA - Lapas Kediri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
            border-radius: 5px;
        }
        .content {
            padding: 20px;
        }
        .card {
            border-radius: 10px;
        }
        .sidebar li a {
            color: #212529;
        }
        .sidebar li a:hover {
            color: #fff;
        }
    </style>
</head>
<body>
    <?php
     $currentUrl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
     $split = explode("/",$currentUrl)[3];
     $url = $split == "siarkanta" ? "/siarkanta" :"";
    ?>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <h4 class="text-white text-center">SIARKANTA</h4>
                <a href="<?php echo $url; ?>/dashboard"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
                @if(in_array(Auth::user()->role, ['user', 'superadmin']))
                <a href="<?php echo $url; ?>/nomor-surat"><i class="fa-solid fa-envelope"></i> Nomor Surat</a>
                @endif
                @if(in_array(Auth::user()->role, ['admin', 'superadmin']))
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa-solid fa-box"></i> Stok Barang
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo $url; ?>/stok-barang"><i class="fa-solid fa-plus"></i> Input Stok Barang</a></li>
                        <li><a class="dropdown-item" href="<?php echo $url; ?>/riwayat-stok"><i class="fa-solid fa-history"></i> Riwayat</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa-solid fa-box"></i> Data BMN
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo $url; ?>/inventaris"><i class="fa-solid fa-plus"></i> Inventaris</a></li>
                        <li><a class="dropdown-item" href="<?php echo $url; ?>/riwayat-kondisi"><i class="fa-solid fa-history"></i> Riwayat Pemeliharaan</a></li>
                    </ul>
                </div>
                <a href="<?php echo $url; ?>/rekap"><i class="fa-solid fa-file-excel"></i> Rekap</a>
                <a href="<?php echo $url; ?>/users"><i class="fa-solid fa-users"></i> Kelola User</a>
                @endif
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('script')
</body>
</html>
