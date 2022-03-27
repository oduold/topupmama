<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use function Illuminate\Database\Eloquent\Casts\get;

class Comment extends Model {
    
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['comment','ip'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['book_id'];
    
    /**
     * 
     * @return Attribute
     */   
    protected function getIpAttribute($value) {
        return long2ip($value);
    }

    public function book() : BelongsTo {
        return $this->belongsTo(Book::class,'book_id');
    }

}