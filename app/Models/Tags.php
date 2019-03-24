<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $fillable = [
        'name'
    ];

    public function books(){
        return $this->BelongsToMany('App\Models\LibraryBooks', 'library_books_tags','tag_id','library_book_id');
    }
}
