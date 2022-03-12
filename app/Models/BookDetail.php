<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class BookDetail extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'book_id',
        'description',
        'pages',
        'publisher',
    ];

}
