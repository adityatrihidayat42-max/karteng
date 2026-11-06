<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicAgendaController;
use App\Http\Controllers\PublicBanomController;
use App\Http\Controllers\PublicDonationController;
use App\Http\Controllers\PublicGalleryController;
use App\Http\Controllers\PublicMemberController;
use App\Http\Controllers\PublicPostController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================================================================
// AUTHENTICATION
// =========================================================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// =========================================================================
// PUBLIC ROUTES
// =========================================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [PublicProfileController::class, 'index'])->name('profil');

// Anggota Publik
Route::get('/anggota', [PublicMemberController::class, 'index'])->name('anggota.index');
Route::get('/anggota/{member}', [PublicMemberController::class, 'show'])->name('anggota.show');
Route::get('/verifikasi-kta/{nis}', [PublicMemberController::class, 'verify'])->name('anggota.verify')->where('nis', '.*');

// Pendaftaran Anggota Online
Route::get('/daftar-anggota', [RegistrationController::class, 'create'])->name('daftar-anggota');
Route::post('/daftar-anggota', [RegistrationController::class, 'store'])->name('daftar-anggota.store')->middleware('throttle:5,10');

// Banom
Route::get('/banom', [PublicBanomController::class, 'index'])->name('banom.index');
Route::get('/banom/{banom:slug}', [PublicBanomController::class, 'show'])->name('banom.show');

// Berita
Route::get('/berita', [PublicPostController::class, 'index'])->name('berita.index');
Route::get('/berita/{post:slug}', [PublicPostController::class, 'show'])->name('berita.show');

// Agenda
Route::get('/agenda', [PublicAgendaController::class, 'index'])->name('agenda.index');
Route::get('/agenda/{agenda:slug}', [PublicAgendaController::class, 'show'])->name('agenda.show');

// Galeri
Route::get('/galeri', [PublicGalleryController::class, 'index'])->name('galeri.index');
Route::get('/galeri/{gallery:slug}', [PublicGalleryController::class, 'show'])->name('galeri.show');

// Donasi / Infaq
Route::get('/donasi', [PublicDonationController::class, 'index'])->name('donasi.index');
<<<<<<< HEAD
Route::post('/donasi', [PublicDonationController::class, 'store'])->name('donasi.store')->middleware('throttle:10,10');
Route::get('/donasi/{donation:public_token}', [PublicDonationController::class, 'show'])->name('donasi.show');
Route::post('/donasi/{donation:public_token}/upload-bukti', [PublicDonationController::class, 'uploadProof'])->name('donasi.upload-bukti')->middleware('throttle:10,10');
=======
Route::post('/donasi', [PublicDonationController::class, 'store'])->name('donasi.store')->middleware('throttle:5,10');
Route::get('/donasi/{transaction_code}', [PublicDonationController::class, 'show'])->name('donasi.show');
Route::post('/donasi/{transaction_code}/upload-bukti', [PublicDonationController::class, 'uploadProof'])->name('donasi.upload-bukti')->middleware('throttle:10,10');
>>>>>>> c62801866525755a687e5889f7ab1e1b07a93a37

// =========================================================================
// ADMIN ROUTES (Protected by auth + admin role)
// =========================================================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Anggota CRUD
    Route::resource('members', Admin\MemberController::class);
    Route::post('members/{member}/approve', [Admin\MemberController::class, 'approve'])->name('members.approve');
    Route::post('members/{member}/reject', [Admin\MemberController::class, 'reject'])->name('members.reject');
    Route::post('members/{member}/toggle-public', [Admin\MemberController::class, 'togglePublic'])->name('members.toggle-public');
    Route::get('members/{member}/kta', [Admin\KtaController::class, 'show'])->name('members.kta');
    Route::get('members/{member}/kta/download', [Admin\KtaController::class, 'download'])->name('members.kta.download');

    // Cetak KTA Berbasis NIS (Khusus Admin / Pengurus)
    Route::get('kta', [Admin\KtaController::class, 'index'])->name('kta.index');
    Route::get('kta/{nis}/download', [Admin\KtaController::class, 'downloadByNis'])->name('kta.download-by-nis');
    Route::get('kta/{nis}', [Admin\KtaController::class, 'showByNis'])->name('kta.show-by-nis');

    
// Banom CRUD (paksa binding pakai ID, karena default route key Banom adalah 'slug' untuk route publik)
Route::resource('banoms', Admin\BanomController::class)
    ->parameters(['banoms' => 'banom:id']);

    // Berita & Kategori CRUD
    Route::resource('posts', Admin\PostController::class);
    Route::resource('categories', Admin\CategoryController::class)->except(['create', 'show', 'edit']);

    // Agenda CRUD
    Route::resource('agendas', Admin\AgendaController::class);

    // Galeri CRUD
    Route::resource('galleries', Admin\GalleryController::class);
    Route::delete('galleries/{gallery}/images/{image}', [Admin\GalleryController::class, 'destroyImage'])->name('galleries.images.destroy');

    // Donasi
    Route::resource('donations', Admin\DonationController::class)->only(['index', 'show']);
    Route::post('donations/{donation}/confirm', [Admin\DonationController::class, 'confirm'])->name('donations.confirm');
    Route::post('donations/{donation}/reject', [Admin\DonationController::class, 'reject'])->name('donations.reject');

<<<<<<< HEAD
    // User/Pengurus dan Profil Organisasi: KHUSUS peran admin (pengurus tidak boleh)
    Route::middleware('role:admin')->group(function () {
        // User / Pengurus CRUD
        Route::resource('users', Admin\UserController::class);

        // Profil Organisasi
        Route::get('organization', [Admin\OrganizationController::class, 'edit'])->name('organization.edit');
        Route::put('organization', [Admin\OrganizationController::class, 'update'])->name('organization.update');
    });
=======
    // User / Pengurus CRUD
    Route::resource('users', Admin\UserController::class)->middleware('admin:admin');

    // Profil Organisasi
    Route::get('organization', [Admin\OrganizationController::class, 'edit'])->name('organization.edit')->middleware('admin:admin');
    Route::put('organization', [Admin\OrganizationController::class, 'update'])->name('organization.update')->middleware('admin:admin');
>>>>>>> c62801866525755a687e5889f7ab1e1b07a93a37
});
