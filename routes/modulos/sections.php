<?php

use App\Livewire\Procedures\Sections\CreateSections;
use App\Livewire\Procedures\Sections\EditSections;
use App\Livewire\Procedures\Sections\IndexSections;
use App\Livewire\Procedures\Sections\ShowSections;
use Illuminate\Support\Facades\Route;



Route::prefix('procedure/{procedure:slug}/sections')
    ->name('sections.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/', IndexSections::class)->name('index');
        Route::get('/create', CreateSections::class)->name('create');
        Route::get('/{section}', ShowSections::class)->name('show');
        Route::get('/{section}/edit', EditSections::class)->name('edit');
    });

