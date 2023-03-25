<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function show()
    {
        return view('public.support.support');
    }

    public function create(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'information' => 'required|string|max:1000',
        ]);

        $support = new Support();
        $support->user = Auth::user()->id;
        $support->name = $validateData['name'];
        $support->contact = $validateData['contact'];
        $support->information = $validateData['information'];
        $support->status = 'New';
        $support->save();

        return redirect()->route('home')->with([
            'message' => 'success',
            'mes_text' => 'The application has been sent, the manager will contact you according to the data you provided.'
        ]);
    }
}
