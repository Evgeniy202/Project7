<?php

namespace App\Http\Controllers\Ajax;

use App\Models\ValueOfChar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    public function getValuesForChar($charId)
    {
        $values = ValueOfChar::query()->where('char', $charId)->orderBy('numberInFilter')->get();

        return response()->json($values);
    }
}
