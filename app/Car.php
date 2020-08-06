<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand', 'class', 'model', 'price',
    ];

    /**
     * Get histories of car.
     */
    public function histories()
    {
        return $this->hasMany('App\History');
    }
}
