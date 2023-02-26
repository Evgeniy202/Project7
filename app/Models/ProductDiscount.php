<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductDiscount extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'product', 'discount', 'begin_date', 'end_date'];

    public $timestamps = false;

    public static function getDiscountsToProducts($categoryId)
    {
        $now = Carbon::now();

        $discounts = DB::table('product_discounts')
            ->join('products', 'product_discounts.product', '=', 'products.id')
            ->where('products.category', $categoryId)
            ->where('product_discounts.begin_date', '<=', $now)
            ->where('product_discounts.end_date', '>', $now)
            ->select('products.id', 'product_discounts.discount', 'product_discounts.end_date')
            ->orderBy('end_date')
            ->get();

        return $discounts;
    }
}
