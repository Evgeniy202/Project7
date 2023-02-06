<?php

namespace App\Http\Controllers\Admin;

use App\Functions\Features\ValuesOfFeatures;
use App\Models\Categories;
use App\Models\CharOfCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CharOfCategoriesController extends Controller
{
    public function featuresOfCategory($categoryId)
    {
        $features = CharOfCategory::query()->where('category', $categoryId)->orderBy('numberInFilter')
            ->get();
        $values = ValuesOfFeatures::getValues($features);
        $category = Categories::query()->find($categoryId);

        return view('admin.features.foCategoryIndex', [
            'category' => $category,
            'features' => $features,
            'values' => $values,
        ]);
    }

    public function store(Request $request, $category)
    {
        $newFeature = new CharOfCategory();

        $newFeature->category = $category;
        $newFeature->title = $request->input('title');

        if (!empty($request->input('numberInFilter')))
        {
            $newFeature->numberInFilter = $request->input('numberInFilter');
        }

        $newFeature->save();

        return redirect()->route('featuresOfCategory', $category)
            ->with(['message' => 'success', 'mes_text' => 'Feature "' . $request->input('title') . '" created!']);
    }

    public function update(Request $request, $category, $featureId)
    {
        $feature = CharOfCategory::query()->find($featureId);

        if (!empty($request->input('numberInFilter')))
        {
            $feature->numberInFilter = $request->input('numberInFilter');
        }

        if (!empty($request->input('title')))
        {
            $feature->title = $request->input('title');
        }

        $feature->save();

        return redirect()->route('featuresOfCategory', $category)
            ->with(["message" => "success", "mes_text" => "Feature changed!"]);
    }

    public function destroy($category, $featureId)
    {
        $feature = CharOfCategory::query()->find($featureId);

        $feature->delete();

        return redirect()->route('featuresOfCategory', $category)
            ->with(["message" => "success", "mes_text" => "Feature changed!"]);
    }
}
