<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\AparaturController;
use App\Http\Controllers\ProdukHukumController;
use App\Http\Controllers\InformasiPublikController;
use App\Http\Controllers\ProdukUmkmController;
use App\Http\Controllers\DemografiKelaminController;
use App\Http\Controllers\DataPendidikanController;
use App\Http\Controllers\DataKesehatanController;
use App\Http\Controllers\DataKeagamaanController;
use App\Http\Controllers\DataEkonomiController;
use App\Models\Berita;
use App\Models\Aparatur;
use App\Models\DataEkonomi;
use App\Models\DataKeagamaan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Ini adalah file routing utama untuk aplikasi web.
| Rute dibagi menjadi:
| 1. Halaman Publik
| 2. Halaman Admin (dengan middleware autentikasi)
*/

/*
|--------------------------------------------------------------------------
| HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'))->name('welcome');

// Profil Wilayah Desa
Route::get('/profil-wilayah', fn() => view('profil-wilayah-desa'))->name('profil-wilayah');

// Sejarah Desa
Route::get('/sejarah-desa', fn() => view('sejarah-desa'))->name('sejarah-desa');

// Kondisi Pemerintahan
Route::get('/kondisi-pemerintahan', fn() => view('kondisi-pemerintahan'))->name('kondisi-pemerintahan');

// Data Jenis Kelamin
Route::get('/data-jenis-kelamin', [DemografiKelaminController::class, 'showPublic'])->name('data-jenis-kelamin');

// Data Pendidikan
Route::get('/data-pendidikan', [DataPendidikanController::class, 'showPublic'])->name('data-pendidikan');

// Data Kesehatan
Route::get('/data-kesehatan', [DataKesehatanController::class, 'showPublic'])->name('data-kesehatan');

// Data Keagamaan
Route::get('/data-keagamaan', [DataKeagamaanController::class, 'showPublic'])->name('data-keagamaan');

// Data Ekonomi
Route::get('/data-ekonomi', [DataEkonomiController::class, 'showPublic'])->name('data-ekonomi');

// Berita Publik
Route::get('/berita', [BeritaController::class, 'publik'])->name('berita.index');
Route::get('/berita/{id}', [BeritaController::class, 'detail'])->name('berita.detail');
Route::post('/berita/{id}/komentar', [BeritaController::class, 'simpanKomentar'])->name('berita.komentar');

// Permohonan Informasi
Route::get('/permohonan-informasi', fn() => view('permohonan-informasi'))->name('permohonan.create');
Route::post('/permohonan-informasi', [PermohonanController::class, 'store'])->name('permohonan.store');

// Dokumen Publik
Route::get('/dokumen', [DokumenController::class, 'dokumenPublik'])->name('dokumen.index');
Route::get('/unduh-dokumen/{id}', [DokumenController::class, 'download'])->name('dokumen.download');

// Galeri Desa
Route::get('/galeri-desa', fn() => view('galeri-desa'))->name('galeri.index');

// Aparatur Desa
Route::get('/aparatur', fn() => view('aparatur'))->name('aparatur.index');

// Produk Hukum
Route::get('/produk-hukum', [ProdukHukumController::class, 'publik'])->name('produk-hukum.index');

// Informasi Publik
Route::get('/informasi-publik', [InformasiPublikController::class, 'publik'])->name('informasi-publik.index');

// Produk UMKM
Route::get('/produk-umkm', [ProdukUmkmController::class, 'publik'])->name('produk-umkm.index');
Route::get('/produk-umkm/{produkUmkm}', [ProdukUmkmController::class, 'showPublik'])->name('produk-umkm.show');
Route::post('/produk-umkm/{id}/komentar', [ProdukUmkmController::class, 'simpanKomentar'])->name('produk-umkm.komentar.store');

/*
|--------------------------------------------------------------------------
| HALAMAN ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Data Jenis Kelamin
    Route::get('/admin/data-kelamin', [DemografiKelaminController::class, 'index'])->name('admin.data-kelamin.index');
    Route::post('/admin/data-kelamin', [DemografiKelaminController::class, 'store'])->name('admin.data-kelamin.store');

    // Data Pendidikan
    Route::get('/admin/data-pendidikan', [DataPendidikanController::class, 'index'])->name('admin.data-pendidikan.index');
    Route::post('/admin/data-pendidikan', [DataPendidikanController::class, 'store'])->name('admin.data-pendidikan.store');

    // Data Kesehatan
    Route::get('/admin/data-kesehatan', [DataKesehatanController::class, 'index'])->name('admin.data-kesehatan.index');
    Route::post('/admin/data-kesehatan', [DataKesehatanController::class, 'store'])->name('admin.data-kesehatan.store');

    // Data Keagamaan
    Route::get('/admin/data-keagamaan', [DataKeagamaanController::class, 'index'])->name('admin.data-keagamaan.index');
    Route::post('/admin/data-keagamaan', [DataKeagamaanController::class, 'store'])->name('admin.data-keagamaan.store');

    // Data Ekonomi
    Route::get('/admin/data-ekonomi', [DataEkonomiController::class, 'index'])->name('admin.data-ekonomi.index');
    Route::post('/admin/data-ekonomi', [DataEkonomiController::class, 'store'])->name('admin.data-ekonomi.store');

    // Dokumen Admin
    Route::resource('/admin/dokumen', DokumenController::class)->names('admin.dokumen');

    // Permohonan Informasi Admin
    Route::get('/admin/permohonan', [PermohonanController::class, 'index'])->name('admin.permohonan.index');
    Route::patch('/admin/permohonan/{id}/toggle', [PermohonanController::class, 'toggleStatus'])->name('admin.permohonan.toggle');

    // Berita Admin
    Route::resource('/admin/berita', BeritaController::class)->names('admin.berita');

    // Galeri Desa
    Route::resource('/admin/galeri', GaleriController::class)->names('admin.galeri');

    // Aparatur Desa
    Route::resource('/admin/aparatur', AparaturController::class)->names('admin.aparatur');

    // Produk Hukum
    Route::resource('/admin/produk-hukum', ProdukHukumController::class)->names('admin.produk-hukum');

    // Informasi Publik
    Route::resource('/admin/informasi-publik', InformasiPublikController::class)->names('admin.informasi-publik');

    // Produk UMKM
    Route::resource('/admin/produk-umkm', ProdukUmkmController::class)->names('admin.produk-umkm');
});
