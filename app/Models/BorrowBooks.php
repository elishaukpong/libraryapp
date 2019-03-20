<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowBooks extends Model
{
    protected $fillable = [
        'user_id', 'library_book_id', 'returned'
    ];
}
 $table->increments('id');
            $table->integer('user_id');
            $tabe->integer('book_id');
            $table->date('return_date')->default(\Carbon\Carbon::now()->addWeeks(2));
            $table->timestamps();
