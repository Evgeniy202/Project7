<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'product_id', 'user_id', 'rating', 'created_at', 'updated_at'];

    public static function getForProducts($products)
    {
        $productIds = [];

        foreach ($products as $product)
        {
            array_push($productIds, $product->id);
        }

        $ratings = self::query()->whereIn('product_id', $productIds)
            ->groupBy('product_id')
            ->selectRaw('product_id, AVG(rating) as rating')
            ->get()
            ->pluck('rating', 'product_id')
            ->toArray();

        return $ratings ?? null;
    }

    public static function getForProduct($productId)
    {
        $rating = self::query()->where('product_id', $productId)->avg('rating');

        return $rating ?? null;
    }
}
