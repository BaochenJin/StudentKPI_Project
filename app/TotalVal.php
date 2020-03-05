<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TotalVal extends Model
{
    //
    public function student()
    {
        return $this->hasOne('App\Student','id','student_id');
    }
}
