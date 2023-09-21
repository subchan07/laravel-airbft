<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $websites = Website::with('pages')->get();
        return view('websites.index', compact('websites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('websites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => ['required']
        ]);
        $validated['slug'] = Str::slug($request->title);
        $website = Website::with('pages')->first();
        $cloneWebsite = $website->replicate()->fill($validated);
        $cloneWebsite->save();
        foreach ($website->pages as $page) {
            if ($page->sub_page === 'home') {
                $clonePage = $page->replicate();
                $clonePage->website()->associate($cloneWebsite);
                if ($page->category === 'review') {
                    $copiedFile = [];
                    $paths = $page->content;
                    foreach ($paths as $path) {
                        //! ----------------------------------- Sec ---------------------------------- */
                        $sourcePath = public_path('uploads/' . $path->image);
                        if (File::exists($sourcePath)) {
                            $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
                            $uniqueFileName = Str::random(10) . '_' . time() . '.' . $extension;
                            $desinationPath = public_path('uploads/main-page/' . $uniqueFileName);

                            File::copy($sourcePath, $desinationPath);

                            $copiedFile[] = ['image' => 'main-page/' . $uniqueFileName];
                        }
                        $clonePage->content = $copiedFile;
                    }
                    //! ----------------------------------- Sec ---------------------------------- */
                } else {
                    $sourcePath = public_path('uploads/' . $page->content->image);
                    if (File::exists($sourcePath)) {
                        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
                        $uniqueFileName = Str::random(10) . '_' . time() . '.' . $extension;
                        $desinationPath = public_path('uploads/main-page/' . $uniqueFileName);

                        File::copy($sourcePath, $desinationPath);

                        $content = $clonePage->content;

                        $content->image = 'main-page/' . $uniqueFileName;
                        $clonePage->content = $content;
                    }
                }
                $clonePage->save();
            }
        }
        return redirect()->route('website.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Website $website)
    {
        return view('websites.edit', compact('website'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Website $website)
    {
        $validated = $request->validate([
            'title' => 'required'
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $website->update($validated);
        return redirect()->route('website.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Website $website)
    {
        $website->delete();
        return redirect()->route('website.index');
    }
}
