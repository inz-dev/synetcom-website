<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\DepartementsController;
use App\Http\Controllers\NousContacterController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\PartnersController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\EmployesController;
use App\Http\Controllers\UserController;
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
Route::get('/services', [ServicesController::class, 'index'])->name('services');
Route::get('/partenaires', [PartnersController::class, 'index'])->name('partenaires');
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
Route::post('/pages', [PagesController::class, 'store'])->name('pages.store');
Route::put('/pages/{page}', [PagesController::class, 'update'])->name('pages.update');
Route::delete('/pages/{page}', [PagesController::class, 'destroy'])->name('pages.destroy');
Route::post('/sections', [PagesController::class, 'storeSection'])->name('sections.store');
Route::put('/sections/{section}', [PagesController::class, 'updateSection'])->name('sections.update');
Route::delete('/sections/{section}', [PagesController::class, 'destroySection'])->name('sections.destroy');
Route::post('/cards', [PagesController::class, 'storeCard'])->name('cards.store');
Route::put('/cards/{card}', [PagesController::class, 'updateCard'])->name('cards.update');
Route::delete('/cards/{card}', [PagesController::class, 'destroyCard'])->name('cards.destroy');
Route::get('/departements', [DepartementsController::class, 'index'])->name('departements');
Route::put('/departements/{departement}', [DepartementsController::class, 'update'])->name('departements.update');
Route::delete('/departements/{departement}', [DepartementsController::class, 'destroy'])->name('departements.destroy');
Route::post('/services', [ServicesController::class, 'store'])->name('services.store');
Route::put('/services/{service}', [ServicesController::class, 'update'])->name('services.update');
Route::delete('/services/{service}', [ServicesController::class, 'destroy'])->name('services.destroy');
Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::post('/roles', [UserController::class, 'storeRole'])->name('roles.store');
Route::put('/roles/{role}', [UserController::class, 'updateRole'])->name('roles.update');
Route::delete('/roles/{role}', [UserController::class, 'destroyRole'])->name('roles.destroy');
Route::get('/employes', [EmployesController::class, 'index'])->name('employes');
Route::post('/employes', [EmployesController::class, 'store'])->name('employes.store');
Route::put('/employes/{employe}', [EmployesController::class, 'update'])->name('employes.update');
Route::delete('/employes/{employe}', [EmployesController::class, 'destroy'])->name('employes.destroy');

});

require __DIR__.'/auth.php';
