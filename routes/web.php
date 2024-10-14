<?php

// Importing necessary classes
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Registering routes that require authentication
Auth::routes();

// Grouping routes that require authentication
Route::middleware('auth')->group(function () {
    // Defining route for homepage
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Defining route for news index page
    Route::get('/News', [NewsController::class, 'index'])->name('news.index');

    // Defining route for news category page
    Route::get('/News/category/{category}', [NewsController::class, 'category'])->name('news.category');

    // Defining route for news author page
    Route::get('/News/author/{id}', [NewsController::class, 'author'])->name('news.author');

    // Defining route for news show page
    Route::get('/News/read/{News}', [NewsController::class, 'show'])->name('news.show');

    // Defining route for news create page
    Route::get('/News/create', [NewsController::class, 'create'])
        ->name('news.create');

    // Defining route for news store
    Route::post('/News', [NewsController::class, 'store'])
        ->name('news.store');

    // Defining route for news delete
    Route::delete('/News/{id}/delete', [NewsController::class, 'destroy'])
        ->name('news.destroy');

    // Defining route for news update
    Route::patch('/News/update', [NewsController::class, 'update'])
        ->name('news.update');

    // Defining route for news edit page
    Route::get('/News/edit/{slug}', [NewsController::class, 'edit'])
        ->name('news.edit');
});