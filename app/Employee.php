<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable = ['full_name', 'image', 'employeementDay', 'salary', 'position_id', 'parent_id'];
    public $timestamps = false;

    function position() {
        return $this->belongsTo('App\Position');
    }

	public function root()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

//    public function subroot()
//    {
//        return $this->hasMany(self::class, 'parent_id', 'id');
//    }
}
