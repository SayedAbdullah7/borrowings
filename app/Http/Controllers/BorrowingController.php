<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    public function borrowBook(Request $request, $userId, $bookId)
    {
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $book = Book::find($bookId);
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        if (!$book->available) {
            return response()->json(['error' => 'Book not available for borrowing'], 400);
        }

        $returnAt = $request->input('return_at');
        if (!$returnAt || !\Carbon\Carbon::parse($returnAt)->isFuture()) {
            return response()->json(['error' => 'Invalid return_at date. It must be a future date.'], 400);
        }

        // Create a borrowing record
        $borrowing = new Borrowing();
        $borrowing->user_id = $user->id;
        $borrowing->book_id = $book->id;
        $borrowing->borrowed_at = now();
        $borrowing->return_at = $returnAt;
        $borrowing->status = 'borrowed';
        $borrowing->save();

        // Update book availability
        $book->available = false;
        $book->save();

        return response()->json(['message' => 'Book borrowed successfully'], 200);
    }

    public function getAllBorrowings()
    {
        $borrowings = Borrowing::all();

        return response()->json($borrowings);
    }
}
