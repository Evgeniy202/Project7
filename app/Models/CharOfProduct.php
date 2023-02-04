<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharOfProduct extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'product', 'char', 'value', 'numberInList'];
}
