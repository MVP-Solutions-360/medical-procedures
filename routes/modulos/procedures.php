<?php

use App\Livewire\Procedures\IndexProcedure;
use App\Livewire\Procedures\CreateProcedure;
use App\Livewire\Procedures\EditProcedure;
use App\Livewire\Procedures\ShowProcedure;
use Illuminate\Support\Facades\Route;



Route::prefix('procedure')->middleware(['auth', 'verified'])->name('procedure.')->group(function () {
    Route::get('/', IndexProcedure::class)->name('index');
    Route::get('/create', CreateProcedure::class)->name('create');
    Route::get('/{procedure:slug}', ShowProcedure::class)->name('show');
    Route::get('/{procedure:slug}/edit', EditProcedure::class)->name('edit');
});
