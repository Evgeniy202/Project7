<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Functions\Sessions\GetCategories;

class MainPageController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function forgetCategoriesSession()
    {
        GetCategories::forgetCategoriesSession();

        return redirect()->back()->with(["message" => "success", "mes_text" => "The session was successfully reset."]);
    }
}
