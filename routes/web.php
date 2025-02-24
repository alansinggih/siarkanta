<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StokBarangController;
use App\Http\Controllers\PencatatanNomorController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\RiwayatKondisiController;
use App\Http\Controllers\ATKController;
use App\Http\Kernel;

Route::get('/debug-kernel', function () {
    $kernel = app(Kernel::class);
    dd('Kernel dipanggil dari /debug-kernel');
});

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/atk', function () {
    return view('atk.form'); // Ganti dengan tampilan yang sesuai
})->middleware(['auth']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Dashboard (Akses Semua User)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // **User Biasa: Hanya Bisa Akses Pencatatan Nomor**
    Route::middleware('role:user,superadmin')->group(function () {
        Route::get('/nomor-surat', [PencatatanNomorController::class, 'index'])->name('pencatatan.nomor.index');
        Route::post('/nomor-surat', [PencatatanNomorController::class, 'store'])->name('pencatatan.nomor.store');
        Route::put('/nomor-surat/{id}', [PencatatanNomorController::class, 'update'])->name('pencatatan.nomor.update');
    });


    Route::middleware('role:admin,atk,superadmin')->group(function () {
        //permintan atk
        Route::get('/atk', [ATKController::class, 'index'])->name('atk.form');
        Route::post('/atk/store', [ATKController::class, 'store'])->name('atk.store');
        Route::get('/export-pdf', [ATKController::class, 'exportPDF'])->name('export.pdf');
        Route::get('/export-pdf-file', [ATKController::class, 'exportPDFFile'])->name('export.pdfFile');
    });
    
    // **Admin & Super Admin (Tidak Bisa Akses Pencatatan Nomor)**
    Route::middleware('role:admin,superadmin')->group(function () {
        Route::get('/manage-items', [DashboardController::class, 'manageItems']);
        Route::get('/stok-barang', [StokBarangController::class, 'index'])->name('stok.index');
        Route::post('/stok-barang/tambah', [StokBarangController::class, 'store'])->name('stok.store');
        Route::post('/stok-barang/edit', [StokBarangController::class, 'update'])->name('stok.update');

        // **Riwayat Stok**
        Route::get('/riwayat-stok', [StokBarangController::class, 'riwayat'])->name('stok.riwayat');
        Route::get('/riwayat-stok/{hashid}', [StokBarangController::class, 'detail'])->name('stok.detail');

        // **Inventaris**
        Route::resource('inventaris', InventarisController::class);
        Route::post('/inventaris', [InventarisController::class, 'store'])->name('inventaris.store');
        Route::put('/inventaris/{inventaris}', [InventarisController::class, 'update'])->name('inventaris.update');
        Route::get('/inventaris/{hashid}', [InventarisController::class, 'show'])->name('inventaris.show');

        // **atk**
        Route::get('/print-atk', [ATKController::class, 'printPermintaan'])->name('print.view');
        Route::get('/printcheck', function () {
            return view('pdf.print'); // Ganti 'print' dengan nama view yang sesuai
        })->name('print.check');

        // **Riwayat Kondisi**
        Route::get('/riwayat-kondisi', [RiwayatKondisiController::class, 'index'])->name('riwayat.kondisi');
    });

    // **Super Admin Only**
    Route::middleware('role:superadmin')->group(function () {
        Route::get('/manage-users', [DashboardController::class, 'manageUsers']);
    });
});

Route::get('/debug-auth', function () {
    return auth()->check() ? auth()->user() : 'Belum login';
});
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/test-role', function () {
        return "Anda user dengan role: " . auth()->user()->role;
    });
});

require __DIR__.'/auth.php';
