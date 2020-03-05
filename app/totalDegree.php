<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class totalDegree extends Model
{
    //
    public function totalVal()
    {
        return $this->hasOne('App\TotalVal', 'id', 'total_vals_id');
    }
}
