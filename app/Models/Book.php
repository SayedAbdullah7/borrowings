<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'author', 'category_id', 'available'];

//    public function category()
//    {
//        return $this->belongsTo(Category::class);
//    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
