<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recentbooks extends Model
{
    protected $fillable = [
        'user_id', 'book_id',
    ];

    public function user(){
        return $this->belongsto('App\User');
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
