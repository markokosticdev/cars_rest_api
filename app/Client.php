<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'firstname', 'lastname', 'email',
    ];

    /**
     * Get histories of client.
     */
    public function histories()
    {
        return $this->hasMany('App\History');
    }
}
