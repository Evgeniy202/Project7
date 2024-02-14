<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $sections = Section::query()->orderBy('priority')->get();

        return view('admin.sections.index', [
            'sections' => $sections,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.sections.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $new_section = new Section();

        if (!empty($request->input('priority')))
            $new_section->priority = $request->input('priority');

        $new_section->title = $request->input('title');

        if (!empty($request->input('section')))
            $new_section->section = $request->input('section');

        $new_section->save();

        return redirect()->route('sections.index')
            ->with(["message" => "success", "mes_text" => "Section created!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Section $section): \Illuminate\Http\RedirectResponse
    {
        if (!empty($request->input('priority')))
        {
            $section->priority = $request->input('priority');
        }

        $section->title = $request->input('title');

        if (!empty($request->input('section')))
        {
            $section->section = $request->input('section');
        }

        $section->save();

        return redirect()->route('sections.index')
            ->with(["message" => "success", "mes_text" => "Section updated!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Section $section): \Illuminate\Http\RedirectResponse
    {
        $section->delete();

        return redirect()->route('sections.index')
            ->with(["message" => "success", "mes_text" => "Section removed!"]);
    }
}
