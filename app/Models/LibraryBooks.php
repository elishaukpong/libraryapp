<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LibrarySections;

class LibraryBooks extends Model
{
    protected $fillable = [
        'name', 'description', 'book_avatar', 'availableCopies', 'borrowedCopies', 'slug', 'avatar',
    ];

    public function sections(){
        return $this->belongsToMany('App\Models\LibrarySection', 'library_books_library_sections');
    }

    public function recents(){
        return $this->hasMany('App\Models\Recentbooks', 'book_id');
    }

    public function borrowed(){
        return $this->hasMany('App\Models\BorrowBooks', 'book_id');
    }

    public function getAvatarAttribute($value){
          return 'storage/avatars/' . $value;
    }
}
