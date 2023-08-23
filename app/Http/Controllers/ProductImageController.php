<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductImageController extends Controller
{
    public function getImages(Product $product)
    {
        $images = ProductImage::where('product_id', $product->id)->get();
        $destinationPath = public_path('uploads/');
        $data = [];
        foreach ($images as $image) {
            if (\file_exists($destinationPath . $image->image)) {
                $data[] = [
                    'name' => str_replace('product-images/', '', $image->image),
                    'size' => filesize($destinationPath . $image->image),
                    'path' => \asset("uploads/" . $image->image),
                ];
            }
        }
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $uploadedFile = $request->file('file');
        $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

        $destinationPath = public_path('uploads/product-images');

        // Pindahkan file yang diunggah ke direktori tujuan
        $uploadedFile->move($destinationPath, $newFileName);

        $imageUpload = new ProductImage;
        $imageUpload->product_id = $request->product_id;
        $imageUpload->image = "product-images/" . $newFileName;
        $imageUpload->save();

        // $filename = str_replace('product-images/', '', $nameFile);
        return response()->json(['success' => $newFileName]);
    }

    public function destroy(Request $request)
    {
        $destinationPath = public_path('uploads/product-images/');
        $filename =  $request->filename;
        if (\file_exists($destinationPath . $filename)) {
            \unlink($destinationPath . $filename);
        }

        ProductImage::where('image', 'product-images/' . $filename)->delete();
        return response()->json(['success' => $filename]);
    }
}
