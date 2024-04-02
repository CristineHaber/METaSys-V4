<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\FinalScoreController;
use App\Http\Controllers\JudgeDashboardController;

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
    return view('auth.login');
});


Route::middleware(['judge', 'auth.prevent'])->group(function () {
    Route::get('/judge', [JudgeDashboardController::class, 'index'])->name('judge.index');
    Route::post('/submit_scores', [ScoreController::class, 'store'])->name('judge.score');
    Route::post('/submit_finalist_scores', [FinalScoreController::class, 'store'])->name('judge.finalist.score');
});


Auth::routes();
