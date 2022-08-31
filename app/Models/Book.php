<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public $primaryKey = 'id';
    protected $fillable = [
        'name',
        'author',
        'cover',
        'price',
    ];
}