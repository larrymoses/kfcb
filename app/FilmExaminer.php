<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilmExaminer extends Model
{
    protected $fillable =  ['userID', 'filmID', 'created_at', 'updated_at'];
}
