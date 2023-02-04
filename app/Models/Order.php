<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user',
        'price',
        'status',
        'name',
        'phone',
        'address',
        'comment',
        'created_at',
        'updated_at'
    ];
}
