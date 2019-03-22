<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = [
        'id',
        'name',
        'account_number',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
