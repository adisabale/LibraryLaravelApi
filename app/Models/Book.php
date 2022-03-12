<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Book extends Model
{
     use HasApiTokens, HasFactory;

    protected $fillable = [
        'category_id',
        'uuid',
        'name',
        'releaseDate',
        'authorName',
        'retailsPrice',
        'imageName',
    ];
}
