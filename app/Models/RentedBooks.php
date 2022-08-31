<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentedBooks extends Model
{

    public $primaryKey = 'id';
    use HasFactory;
    protected $fillable = [
        'book_id',
        'client_id',

    ];
}