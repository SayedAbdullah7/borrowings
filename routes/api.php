<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BorrowingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::prefix('borrowings')->group(function () {
    Route::post('/users/{userId}/books/{bookId}/borrow', [BorrowingController::class, 'borrowBook']); // Borrow a book
    Route::get('/all', [BorrowingController::class, 'getAllBorrowings']); // Get all borrowings
});

