<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestsUsers extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id',
        'request_id',
        'user_id',
        'email',
        'status'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function request()
    {
        return $this->belongsTo('App\PaymentRequest');
    }
}
