<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Selected;

class SelectedProductsController extends Controller
{
    public function action(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
        ]);
;
        $selected = new Selected();
        $selected->user = $validatedData['user_id'];
        $selected->product = $validatedData['product_id'];

        $coincidence = Selected::query()
            ->where('user', $selected->user)
            ->where('product', $selected->product)
            ->first();

        if (empty($coincidence))
        {
            $selected->save();
        }
        else
        {
            $coincidence->delete();
        }

        return response()->json(['status' => 'success', 'selected' => $selected]);
    }
}
