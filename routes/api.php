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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::prefix('borrowings')->group(function () {
    Route::post('/users/{userId}/books/{bookId}/borrow', [BorrowingController::class, 'borrowBook']); // Borrow a book
    Route::post('/users/{userId}/books/{bookId}/return', [BorrowingController::class, 'returnBook']); // Return a book
    Route::get('/users/{userId}/', [BorrowingController::class, 'getUserBorrowings']); // Get user's borrowings
    Route::get('/all', [BorrowingController::class, 'getAllBorrowings']); // Get all borrowings
});

