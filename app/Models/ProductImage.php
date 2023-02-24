<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'product', 'isMain', 'image', 'position', 'created_at', 'updated_at'];

    public static function getMainImages($products)
    {
        $mainImages = array();
        $allMainImages = self::query()->where('isMain', 1)->get();

        foreach ($products as $product)
        {
            $mainImages[$product->id] = $allMainImages->where('product', $product->id)->first()->image;
        }

        return $mainImages;
    }
}
