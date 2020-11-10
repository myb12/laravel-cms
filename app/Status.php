<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table='status';
    protected $dates = ['created_at'];
    
    function user(){ //Defining the relation between status and user table
        return $this->belongsTo(\App\User::class);
    }
}
