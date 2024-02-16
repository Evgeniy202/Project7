<?php

namespace App\Http\Controllers\Admin;

use App\Functions\Sessions\GetCategories;
use App\Models\Categories;
use App\Models\CharOfCategory;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $categories = Categories::query()->orderBy('priority')
            ->leftJoin('sections', 'categories.section', '=', 'sections.id')
            ->select('categories.*', 'sections.title as section_title')
            ->get();
        $charList = CharOfCategory::query()->orderBy('numberInFilter')->get();
        $sections = Section::query()->orderBy('priority')->get();

        return view('admin.categories.index', [
            'categories' => $categories,
            'charList' => $charList,
            'sections' => $sections,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $sections = Section::query()->orderBy('priority')->get();

        return view('admin.categories.create', [
            'sections' => $sections,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $new_category = new Categories();

        if (!empty($request->input('priority')))
            $new_category->priority = $request->input('priority');

        $new_category->title = $request->input('title');

        if (!empty($request->input('section')))
            if ($request->input('section') == 'null')
                $new_category->section = null;
            else
                $new_category->section = $request->input('section');

        $new_category->save();

        return redirect()->route('categories.index')
            ->with(["message" => "success", "mes_text" => "Category created!"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categories  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Categories $category): \Illuminate\Http\RedirectResponse
    {
        if (!empty($request->input('priority')))
            $category->priority = $request->input('priority');

        $category->title = $request->input('title');

        if (!empty($request->input('section')))
            $category->section = $request->input('section');

        if (!empty($request->input('section')))
            if ($request->input('section') == 'null')
                $category->section = null;
            else
                $category->section = $request->input('section');

        $category->save();

        return redirect()->route('categories.index')
            ->with(["message" => "success", "mes_text" => "Category updated!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Categories $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with(["message" => "success", "mes_text" => "Category removed!"]);
    }
}
