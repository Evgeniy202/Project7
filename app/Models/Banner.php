<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $visible = ['id', 'active', 'priority', 'tittle', 'link', 'description', 'created_at', 'updated_at'];
}
