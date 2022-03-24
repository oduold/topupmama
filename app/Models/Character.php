<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['book_id'];

    public function book() {
        $this->belongsTo(Book::class,'book_id');
    }
    
    public function gender() {        
       $this->hasOne(Gender::class,'gender_id');
    }
}