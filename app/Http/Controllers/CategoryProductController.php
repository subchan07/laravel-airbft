<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoryProducts = CategoryProduct::all();
        return \view('category-product.index', \compact('categoryProducts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return \view('category-product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'thumbnail' => 'image|file|mimes:png,jpg,jpeg',
            'description' => 'required'
        ]);

        if ($request->file('thumbnail')) {
            $uploadedFile = $request->file('thumbnail');
            $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

            $destinationPath = public_path('uploads/product-images/category');

            // Pindahkan file yang diunggah ke direktori tujuan
            $uploadedFile->move($destinationPath, $newFileName);

            $validatedData['thumbnail'] = "product-images/category/" . $newFileName;
        } else {
            $validatedData['thumbnail'] = null;
        }
        // $validatedData['user_id'] = \auth()->user()->id;

        CategoryProduct::create($validatedData);

        return response()->json([
            'statusFlashMessage' => 'success',
            'textFlashMessage' => '<strong>Success,</strong> New category product has been added!'
        ], 200);
    }

    public function edit(CategoryProduct $category)
    {
        return \view('category-product.edit', \compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryProduct $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'thumbnail' => 'image|file|mimes:png,jpg,jpeg',
            'description' => 'required'
        ]);

        $slug = SlugService::createSlug(CategoryProduct::class, 'slug', $request->name);
        $validatedData['slug'] = $validatedData['name'] !== $category->name ? $slug : $category->slug;

        if ($request->file('thumbnail')) {
            $uploadedFile = $request->file('thumbnail');
            $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

            $destinationPath = public_path('uploads/product-images/category');

            // Pindahkan file yang diunggah ke direktori tujuan
            $uploadedFile->move($destinationPath, $newFileName);

            $validatedData['thumbnail'] = "product-images/category/" . $newFileName;


            if ($category->thumbnail != null && \file_exists(\public_path('uploads/') . $category->thumbnail)) {
                \unlink(\public_path('uploads/') . $category->thumbnail);
            }
        } else {
            $validatedData['thumbnail'] = $category->thumbnail ?? null;
        }

        CategoryProduct::where('id', $category->id)->update($validatedData);

        return response()->json([
            'statusFlashMessage' => 'success',
            'textFlashMessage' => '<strong>Success,</strong> Category product has been updated!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryProduct $category)
    {
        $destinationPath = public_path('uploads/');

        if (count($category->product) == 0) {
            if ($category->thumbnail != null && \file_exists($destinationPath . $category->thumbnail)) {
                \unlink($destinationPath . $category->thumbnail);
            }

            $category->delete();
        }
        return response()->json([
            'statusFlashMessage' => 'success',
            'textFlashMessage' => '<strong>Success,</strong> Category product has been deleted!'
        ], 200);
    }

    public function dataJson(Request $request)
    {
        if ($request->condition == 'all') {
            return CategoryProduct::all();
        } else if ($request->condition == 'fetchOne') {
            return CategoryProduct::findorFail($request->v);
        }
    }
}
