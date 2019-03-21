<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowBooks extends Model
{
    protected $fillable = [
        'user_id', 'library_book_id', 'returned'
    ];

    protected $dates = [
        'return_date'
    ];

    public function book(){
        return $this->belongsTo('App\Models\LibraryBooks');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

}
