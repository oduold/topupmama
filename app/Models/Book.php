<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @author don
 *
 */
class Book extends Model {
    
    use HasFactory;

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
    
    public function comments() : HasMany {
        return $this->hasMany(Comment::class);
    }

    public function characters() : HasMany {
        return $this->hasMany(Character::class);
    }
    
    public function authors() : BelongsToMany {
        return $this->belongsToMany(Author::class)->using(AuthorBook::class);
    }
}