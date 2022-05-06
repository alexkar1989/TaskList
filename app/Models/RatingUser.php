<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingUser extends Model
{
    use HasFactory;

    protected $fillable = ['producer', 'user_id', 'rating'];
    public $timestamps = false;
}

