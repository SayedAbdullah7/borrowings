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

        $isBorrowed =Borrowing::where('book_id', $bookId)->where('return_at', '>', now())->first();
        if ($isBorrowed) {
            return response()->json(['error' => 'The book is already borrowed.'], 400);
        }


        $returnAt = $request->input('return_at');
        if (!$returnAt || !\Carbon\Carbon::parse($returnAt)->isFuture()) {
            return response()->json(['error' => 'Invalid return_at date. It must be a future date.'], 400);
        }

        // Create a borrowing record
        $borrowing = new Borrowing();
        $borrowing->user_id = $userId;
        $borrowing->book_id = $bookId;
        $borrowing->borrowed_at = now();
        $borrowing->return_at = $returnAt;
        $borrowing->status = 'borrowed';
        $borrowing->save();


        return response()->json(['message' => 'Book borrowed successfully'], 200);
    }

    public function getAllBorrowings()
    {
        $borrowings = Borrowing::all();

        return response()->json($borrowings);
    }
}
