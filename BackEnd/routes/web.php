<?php

use App\Http\Controllers\MasterMaterialController;
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
    return 'DEFAULT PAGE ';
    //return view('welcome');
});

//Route::get('/material', [MasterMaterialController::class, 'index']);

// Route::get('/material', function () {
//     return 'Hello World';
// });

// Route::get(
//     '/material',
//     [MasterMaterialController::class, 'index']
// )->name('material');
