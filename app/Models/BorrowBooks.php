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

    public function user(){
        return $this->belongsTo('App\User');
    }

     public function library(){
        return $this->belongsTo('App\Models\Library');
    }

    public function section(){
        return $this->belongsTo('App\Models\LibrarySection', 'library_section_id');
    }

    public function book(){
        return $this->belongsto('App\Models\LibraryBooks');
    }

}
