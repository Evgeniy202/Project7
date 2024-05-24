<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Functions\Sessions\GetCategories;
use Carbon\Carbon;

class MainPageController extends Controller
{
    public function index()
    {
        $registrations = User::query()->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->toArray();

        $dates = array_column($registrations, 'date');
        $counts = array_column($registrations, 'count');

        return view('admin.index', [
            'dates' => $dates,
            'counts' => $counts,
    ]);
    }

    public function forgetCategoriesSession()
    {
        GetCategories::forgetCategoriesSession();

        return redirect()->back()->with(["message" => "success", "mes_text" => "The session was successfully reset."]);
    }
}
