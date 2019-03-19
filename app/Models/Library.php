<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Library extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'location', 'email', 'user_id', 'slug',
    ];

    public function getInitialAttribute(){
        return substr($this->name, 0, 1);
    }

    public function sections(){
        return $this->hasMany('App\Models\LibrarySection');
    }
}
