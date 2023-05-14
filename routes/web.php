<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/refill/simulate', [App\Http\Controllers\RefillController::class, 'generateTextCode'])->name('refill.simulate');
    Route::get('/refill/ask', [App\Http\Controllers\RefillController::class, 'ask'])->name('refill.ask');
    Route::get('/refill/done', [App\Http\Controllers\RefillController::class, 'requestDone'])->name('refill.done');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/dealer', App\Http\Controllers\DealerController::class);
    Route::resource('/stock', App\Http\Controllers\StockController::class);
    Route::resource('/refill', App\Http\Controllers\RefillController::class);
    Route::resource('/order', App\Http\Controllers\OrderController::class);
    Route::resource('/product', App\Http\Controllers\ProductController::class);

    Route::get('/stock/pickup/{stock}', [App\Http\Controllers\StockController::class, 'pickup'])->name('stock.pickup');

    Route::get('/order/{order}/completed', [App\Http\Controllers\OrderController::class, 'completed'])->name('order.completed');


});


require __DIR__.'/auth.php';
