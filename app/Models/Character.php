<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Character extends Model {
    
    use HasFactory;

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
    protected $hidden = ['book_id','gender_id'];

    public function book() : BelongsTo {
        return $this->belongsTo(Book::class,'book_id');
    }
    
    public function gender() : BelongsTo {        
        return $this->belongsTo(Gender::class,'gender_id');
    }
}