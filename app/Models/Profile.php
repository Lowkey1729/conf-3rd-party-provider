<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'nin',
        'bvn',
        'first_name',
        'last_name',
        'middle_name',
        'address',
    ];
}
