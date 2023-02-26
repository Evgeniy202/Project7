<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'category',
        'title',
        'slug',
        'description',
        'price',
        'isAvailable',
        'isFavorite',
        'count',
        'created_at',
        'updated_at',
    ];

    public static function searchAdmin($query)
    {
        return Products::query()
            ->where('title', 'LIKE', '%'.$query.'%')
            ->orWhere('slug', 'LIKE', '%'.$query.'%')
            ->paginate(20);
    }

    public static function searchAllPublic($query)
    {
        return Products::query()
            ->where('title', 'LIKE', '%'.$query.'%')
            ->paginate(20);
    }

    public static function searchInCategoryPublic($query, $category)
    {
        return Products::query()
            ->where('category', $category)
            ->where('title', 'LIKE', '%'.$query.'%')
            ->paginate(20);
    }
}
