<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['pivot'];

    
    public function books() {
        return $this->belongsToMany(Book::class)->using(AuthorBook::class);
    }
    
}