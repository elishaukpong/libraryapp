<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LibrarySections;

class LibraryBooks extends Model
{
     public function sections(){
        return $this->belongsToMany('App\Models\LibrarySections', 'library_books_library_sections');
    }
}
