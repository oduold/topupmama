<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Book extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','release_date'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
    
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function characters() {
        return $this->hasMany(Character::class);
    }
    
    public function authors() {
        return $this->belongsToMany(Author::class)->using(AuthorBook::class);
    }
}