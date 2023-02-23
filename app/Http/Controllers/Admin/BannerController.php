<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $banners = Banner::query()->orderBy('priority')->get();

        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required',
            'title' => 'required|max:255',
            'link' => 'nullable|max:500',
            'description' => 'nullable',
            'priority' => 'numeric|nullable',
            'active' => 'boolean',
        ]);

        $banner = Banner::createBanner($validatedData);

        return redirect()->route('banner.show', $banner)
            ->with(["message" => "success", "mes_text" => "Banner created successfully."]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Banner $banner
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Banner $banner)
    {
        $validatedData = $request->validate([
            'image' => 'nullable',
            'title' => 'required|max:255',
            'link' => 'nullable|max:500',
            'description' => 'nullable',
            'priority' => 'numeric|nullable',
            'active' => 'boolean',
        ]);

        $banner->updateBanner($validatedData, $banner);

        return redirect()->back()
            ->with(["message" => "success", "mes_text" => "Banner updated successfully."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Banner $banner
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()->route('banner.index')
            ->with(["message" => "success", "mes_text" => "Banner removed successfully."]);
    }
}
