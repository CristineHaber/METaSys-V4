<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\JudgeController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\SegmentController;
use App\Http\Controllers\FinalistController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\ProfileController;

Route::middleware(['auth', 'auth.prevent', 'admin'])->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/my-account', [ProfileController::class, 'index'])->name('edit.index');
    Route::post('/my-account-update/profile', [ProfileController::class, 'profile'])->name('update.profile');
    Route::post('/my-account-update', [ProfileController::class, 'update'])->name('update.password');


    // Admin event routes
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('create', [EventController::class, 'create'])->name('create');
        Route::get('archives', [EventController::class, 'history'])->name('archives.history');
        Route::get('{event}', [EventController::class, 'show'])->name('show');
        Route::post('store', [EventController::class, 'store'])->name('store');
        Route::put('{event}', [EventController::class, 'update'])->name('update');
        Route::put('{event}/image', [EventController::class, 'update_image'])->name('update_image');
        Route::patch('{event}/restore', [EventController::class, 'restore'])->name('archives.restore');
        Route::delete('{event}', [EventController::class, 'destroy'])->name('destroy');
    });

    // Admin judge routes
    Route::prefix('judges')->name('judges.')->group(function () {
        Route::post('store', [JudgeController::class, 'store'])->name('store');
        Route::put('{judge}', [JudgeController::class, 'update'])->name('update');
        Route::delete('{judge}/judge', [JudgeController::class, 'destroy'])->name('destroy');
    });

    // Admin candidate routes
    Route::prefix('candidates')->name('candidates.')->group(function () {
        Route::post('store', [CandidateController::class, 'store'])->name('store');
        Route::put('{candidate}', [CandidateController::class, 'update'])->name('update');
        Route::delete('{event}/{candidate}', [CandidateController::class, 'destroy'])->name('destroy');
    });

    Route::get('events/{event}/segment/{segment}/result', [ResultController::class, 'index'])->name('events.results.index');
    Route::get('generate-pdf/{event}/{segment}/mr', [ResultController::class, 'generatePDFMr'])->name('mr.generate.pdf');
    Route::get('generate-pdf/{event}/{segment}/ms', [ResultController::class, 'generatePDFMs'])->name('ms.generate.pdf');


    Route::get('/finalist/{event}/{finalist}', [FinalistController::class, 'finalist_index'])->name('events.finalist.index');
    Route::get('generate-finalist-pdf/{event}/{finalist}', [ResultController::class, 'generateFinalist'])->name('generate.pdf.finalist');

    Route::get('/generate/result/{event}/mr', [FinalistController::class, 'generateResult'])->name('generate.result');
    Route::get('/generate/result/{event}/ms', [FinalistController::class, 'generateResult1'])->name('generate.result1');




    // Admin segment routes

    Route::get('/events/{event}/segment/{segment}', [SegmentController::class, 'index'])->name('events.segments.index');
    Route::get('segments', [SegmentController::class, 'index'])->name('segments.index');
    Route::post('segments/segment', [SegmentController::class, 'store_criteria'])->name('segments.store_criteria');
    Route::put('segments/segment/update', [SegmentController::class, 'criteria_update'])->name('criteria_update');
    Route::post('segments', [SegmentController::class, 'store'])->name('segments.store');
    Route::get('segments/{segment}', [SegmentController::class, 'show'])->name('segments.show');
    Route::put('segments/{segment}', [SegmentController::class, 'update'])->name('segments.update');
    Route::put('segments/{segment}/segment', [SegmentController::class, 'update_segment'])->name('segments.update_segment');
    Route::get('segments/{segment}/criterias', [SegmentController::class, 'criterias'])->name('segments.criterias');
    Route::delete('segments/{event}/{segment}', [SegmentController::class, 'destroy'])->name('segments.destroy');
    Route::delete('criteria/{criteria}', [SegmentController::class, 'destroy_criteria'])->name('criteria.destroy');




    // Finalists routes
    // Route::get('finalists/event/{event}', [FinalistController::class, 'index'])->name('finalist.index');
    Route::get('finalists/event/{event}', [FinalistController::class, 'index'])->name('finalist.index');
    Route::post('finalists/finalist', [FinalistController::class, 'finalist_segment'])->name('finalists.store_finalist');
    Route::put('finalists/finalist/update', [FinalistController::class, 'final_criteria_update'])->name('final_criteria_update');
    Route::get('events/{event}/finalist/{finalist}/result', [ResultController::class, 'result_finalist'])->name('finalist.result');
    Route::post('finalists', [FinalistController::class, 'store'])->name('finalist.store');
    Route::put('finalists/{finalist}/finalist', [FinalistController::class, 'update_finalist'])->name('finalists.update_finalist');
    Route::delete('finalists/{event}/{finalist}', [FinalistController::class, 'destroy'])->name('finalists.destroy');
    Route::delete('final_criteria/{final_criteria}/destroy', [FinalistController::class, 'destroy_finalist_criteria'])->name('final_criteria.destroy');

    Route::get('logs', [AuditTrailController::class, 'index']);
});
