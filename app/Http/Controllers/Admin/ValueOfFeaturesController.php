<?php

namespace App\Http\Controllers\Admin;

use App\Models\ValueOfChar;
use Illuminate\Http\Request;
use App\Models\CharOfCategory;
use App\Functions\Features\ValuesOfFeatures;
use App\Http\Controllers\Controller;

class ValueOfFeaturesController extends Controller
{
    public function index($category, $featureId)
    {
        $feature = CharOfCategory::query()->find($featureId);
        $values = ValueOfChar::query()->where('char', $featureId)->orderBy('numberInFilter')->get();

        return view('admin.features.values', [
            'category' => $category,
            'feature' => $feature,
            'values' => $values,
        ]);
    }

    public function create(Request $request, $category, $featureId)
    {
        $review = new ValueOfChar();

        $review->char = $featureId;
        $review->value = $request->input('title');

        if (!empty($request->input('numberInFilter')))
        {
            $review->numberInFilter = $request->input('numberInFilter');
        }

        $review->save();

        return redirect()->route('valuesOfFeature', [$category, $featureId])
            ->with(['message' => 'success', 'mes_text' => 'Value "' . $request->input('title') . '" created!']);
    }

    public function update(Request $request, $category, $featureId, $valueId)
    {
        $review = ValueOfChar::query()->find($valueId);

        if ((!empty($request->input('numberInFilter'))) && ($request->input('numberInFilter') != $review->numberInFilter))
        {
            $review->numberInFilter = $request->input('numberInFilter');
        }

        if ((!empty($request->input('title'))) && ($request->input('title') != $review->value))
        {
            $review->value = $request->input('title');
        }

        $review->save();

        return redirect()->route('valuesOfFeature', [$category, $featureId])
            ->with(["message" => "success", "mes_text" => "Value changed!"]);
    }

    public function remove($category, $featureId, $valueId)
    {
        $review = ValueOfChar::query()->find($valueId);
        $review->delete();

        return redirect()->route('valuesOfFeature', [$category, $featureId])
            ->with(["message" => "success", "mes_text" => "Value removed!"]);
    }
}
