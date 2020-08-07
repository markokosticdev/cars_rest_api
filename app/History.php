<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'car_id', 'type', 'payed',
    ];

    /**
     * Get client of history.
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    /**
     * Get car of history.
     */
    public function car()
    {
        return $this->belongsTo('App\Car');
    }
}
