<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'positions';
    protected $fillable = ['name'];
    public $timestamps = false;

    function employee() {
        return $this->hasMany('App\Employee');
    }
}
