<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'title', 'priority'];

//    public function categories(): \Illuminate\Database\Eloquent\Relations\HasMany
//    {
//        return $this->hasMany(Categories::class);
//    }
}
