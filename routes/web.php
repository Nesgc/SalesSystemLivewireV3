<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Categories;
use App\Livewire\Coins;
use App\Livewire\EditCoin;
use Illuminate\Support\Facades\Route;
use App\Livewire\PostComponent;
use App\Livewire\ImageUpload;
use App\Livewire\Permissions;
use App\Livewire\Pos;
use App\Livewire\Products;
use App\Livewire\Roles;
use App\Livewire\Select2;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*

Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('categories', Categories::class);

Route::get('products', Products::class);

Route::get('coins', Coins::class);

Route::get('sales', Pos::class);

Route::get('roles', Roles::class)->name('roles');;

Route::get('permissions', Permissions::class);


Route::get('select2', select2::class);

Route::get('/', Categories::class);


Route::get('/posts', PostComponent::class)->name('posts2');

Route::get('/image-upload', ImageUpload::class)->name('posts');

Route::get('/modal', EditCoin::class)->name('editcoin');

require __DIR__ . '/auth.php';
