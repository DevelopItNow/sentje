<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public $timestamps = false;

    protected $primaryKey = ['user_id', 'contact_id'];
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'contact_id',
    ];
}
