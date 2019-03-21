<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LibrarySections;

class LibraryBooks extends Model
{
    protected $fillable = [
        'name', 'description', 'book_avatar', 'availableCopies', 'borrowedCopies', 'slug', 'avatar','book_id', 'library_section_id'
    ];

    public function sections(){
        return $this->belongsTo('App\Models\LibrarySection');
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
