<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    protected $fillable = [
        'instructor','year','semester','courseCode','total','midterm','good','below','failed','excellent','create_at','updated_at'
    ];

    // public function user()
    // {
    //     return $this->hasOne('App\User','instructor','user_id');
    // }

}
