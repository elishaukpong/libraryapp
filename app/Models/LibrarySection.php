<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LibraryBooks;
use Illuminate\Database\Eloquent\SoftDeletes;

class LibrarySection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'library_id',
    ];

    public function library(){
        return $this->belongsTo('App\Models\Library');
    }

    public function books(){
        return $this->belongsToMany('App\Models\LibraryBooks', 'library_books_library_sections');
    }

      public function getInitialAttribute(){
        return substr($this->name, 0, 1);
    }

}
