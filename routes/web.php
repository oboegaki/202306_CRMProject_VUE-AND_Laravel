<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InertiaTestController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
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


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

//ダッシュボード
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Items ルート(resource)
Route::resource('items', ItemController::class)
    ->middleware(['auth', 'verified']);


//Cutomer ルート(resource)
Route::resource('customers', CustomerController::class)
    ->middleware(['auth', 'verified']);

//purchase ルート(resource)
Route::resource('purchases', PurchaseController::class)
    ->middleware(['auth', 'verified']);



// Inertiaテスト
Route::get('/inertia-test', function () {
    return Inertia::render('InertiaTest');
});


// CLUDテスト
Route::get('/inertia/index', [InertiaTestController::class, 'index'])->name('inertia.index');
Route::get('/inertia/create', [InertiaTestController::class, 'create'])->name('inertia.create');
Route::post('/inertia', [InertiaTestController::class, 'store'])->name('inertia.store');
Route::get('/inertia/show/{id}', [InertiaTestController::class, 'show'])->name('inertia.show');
Route::delete('/inertia/{id}', [InertiaTestController::class, 'delete'])->name('inertia.delete');

// 1.defineProps(コンポーネントテスト)
Route::get('/component-test', function () {
    return Inertia::render('ComponentTest');
});
// 2. defineEmits(コンポーネントテスト)
Route::get('/component-test2', function () {
    return Inertia::render('ComponentTest2');
});



/*
 * データ分析
 */

// Analysis
Route::get('analysis', [AnalysisController::class, 'index'])->name('analysis');











require __DIR__ . '/auth.php';