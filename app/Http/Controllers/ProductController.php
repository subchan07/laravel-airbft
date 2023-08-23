<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Models\Product;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['productImages', 'category'])->get();
        return \view('product.index', \compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryProducts = CategoryProduct::all();
        return \view('product.create', \compact('categoryProducts'));
    }

    public function imageUpload(Product $product)
    {
        return \view('product.image-upload', \compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_product_id' => 'required',
            'name' => 'required|max:255',
            'price' => 'required',
            'stock' => 'required|min:0',
            'discount' => 'required|min:0',
            'excerpt' => 'required',
            'description' => 'required'
        ]);


        // $validatedData['user_id'] = \auth()->user()->id;

        Product::create($validatedData);

        return response()->json([
            'statusFlashMessage' => 'success',
            'textFlashMessage' => '<strong>Success,</strong> New product has been added!'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categoryProducts = CategoryProduct::all();
        return \view('product.edit', \compact('product', 'categoryProducts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'category_product_id' => 'required',
            'name' => 'required|max:255',
            'price' => 'required',
            'stock' => 'required|min:0',
            'discount' => 'required|min:0',
            'excerpt' => 'required',
            'description' => 'required'
        ]);

        $slug = SlugService::createSlug(Product::class, 'slug', $request->name);
        $validatedData['slug'] = $validatedData['name'] !== $product->name ? $slug : $product->slug;
        // $validatedData['user_id'] = \auth()->user()->id;
        Product::where('id', $product->id)->update($validatedData);

        return response()->json([
            'statusFlashMessage' => 'success',
            'textFlashMessage' => '<strong>Success,</strong> Product has been updated!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $destinationPath = public_path('uploads/');

        // Hapus gambar terkait dari folder menggunakan model productImage
        foreach ($product->productImages as $image) {
            if (\file_exists($destinationPath . $image->image)) {
                \unlink($destinationPath . $image->image);
            }
            // Storage::delete($image->image);
        }

        // Hapus Product
        $product->delete();

        return response()->json([
            'statusFlashMessage' => 'success',
            'textFlashMessage' => '<strong>Success,</strong> Product has been deleted!'
        ], 200);
    }

    public function allJson()
    {
        $products = Product::all();
        return response()->json($products, 200);
    }
}
