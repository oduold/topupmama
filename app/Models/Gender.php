<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model {

    protected $table = 'gender';
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
    protected $hidden = [];


}