<?php

namespace App\Functions\Sessions;

use App\Models\Categories;
use Illuminate\Support\Facades\Session;

class GetCategories
{
    public static function getCategoriesList()
    {
        if (empty(session('categoriesList')))
        {
            session(['categoriesList' => Categories::query()->orderBy('priority', 'asc')->get()]);
            $categoriesList = Categories::query()->orderBy('priority', 'asc')->get();
        }
        elseif (!empty(session('categoriesList')))
        {
            $categoriesList = session('categoriesList');
        }

        return $categoriesList;
    }

    public static function forgetCategoriesSession()
    {
        Session::forget('categoriesList');
    }
}
