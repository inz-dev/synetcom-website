<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\DepartementsController;
use App\Http\Controllers\NousContacterController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])->name('home');
#Route::get('/users', [UserController::class, 'index'])->name('users');


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::resource('nous-contacter', NousContacterController::class);
Route::resource('about-us', AboutUsController::class);
Route::resource('departements',DepartementsController::class);
Route::get('nous-contacter', [NousContacterController::class, 'index'])->name('nous-contacter');
Route::get('about-us', [AboutUsController::class, 'index'])->name('about-us');
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
Route::get('/pages', [PagesController::class, 'index'])->name('pages');
Route::get('/departements',[DepartementsController::class,'index' ])->name('departements');
Route::get('/reports',[ReportsController::class,'index' ])->name('reports');

});

require __DIR__.'/auth.php';
