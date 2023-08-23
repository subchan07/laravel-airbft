<?php

namespace App\Http\Controllers;

use App\Models\HomePage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomePageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $homePages = HomePage::all();
        return \view('admin-home.index', \compact('homePages'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomePage $home)
    {
        if ($home->category == 'header') {
            return \view('admin-home.edit.header', \compact('home'));
        } else if (\in_array($home->category, ['event', 'front-shop-1', 'front-shop-2', 'front-shop-3'])) {
            return \view('admin-home.edit.font-shop', \compact('home'));
        } else if ($home->category == 'articles') {
            return \view('admin-home.edit.articles', \compact('home'));
        } else if ($home->category == 'academy') {
            return \view('admin-home.edit.academy', \compact('home'));
        } else if ($home->category == 'product-catalog') {
            return \view('admin-home.edit.upload-catalog', \compact('home'));
        } else if (\in_array($home->category, ['gallery', 'gallery-review'])) {
            return \view('admin-home.edit.dropzone-image', \compact('home'));
        } else if ($home->category == 'video') {
            return \view('admin-home.edit.dropzone-video', \compact('home'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomePage $home)
    {
        $customMessage = '';
        $validatedData = [];

        if ($home->category == 'header') {
            $request->validate([
                'image_desktop' => 'file|mimes:png,jpg,jpeg',
                'image_mobile' => 'file|mimes:png,jpg,jpeg',
            ]);

            if ($request->file('image_desktop')) {
                $uploadedFile = $request->file('image_desktop');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path('uploads/home-images/header');

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['image_desktop'] = "home-images/header/" . $newFileName;

                if ($home->data != null && $home->data->image_desktop != null && file_exists("uploads/" . $home->data->image_desktop)) {
                    unlink("uploads/" . $home->data->image_desktop);
                }
            } else {
                $validatedData['image_desktop'] = $home->data->image_desktop ?? null;
            }

            if ($request->file('image_mobile')) {
                $uploadedFile = $request->file('image_mobile');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path('uploads/home-images/header');

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['image_mobile'] = "home-images/header/" . $newFileName;

                if ($home->data != null && $home->data->image_mobile != null && file_exists("uploads/" . $home->data->image_mobile)) {
                    unlink("uploads/" . $home->data->image_mobile);
                }
            } else {
                $validatedData['image_mobile'] = $home->data->image_mobile ?? null;
            }
        } else if ($home->category == 'product-catalog') {
            $request->validate([
                'upload_image' => 'file|mimes:png,jpg,jpeg',
                'upload_pdf' => 'file|mimes:pdf',
            ]);

            if ($request->file('upload_image')) {
                $uploadedFile = $request->file('upload_image');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path('uploads/home-images/product-catalog');

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['upload_image'] = "home-images/product-catalog/" . $newFileName;

                if ($home->data != null && $home->data->upload_image != null && file_exists("uploads/" . $home->data->upload_image)) {
                    unlink("uploads/" . $home->data->upload_image);
                }
            } else {
                $validatedData['upload_image'] = $home->data->upload_image ?? null;
            }

            if ($request->file('upload_pdf')) {
                $uploadedFile = $request->file('upload_pdf');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path('uploads/home-images/product-catalog');

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['upload_pdf'] = "home-images/product-catalog/" . $newFileName;

                if ($home->data != null && $home->data->upload_pdf != null && file_exists("uploads/" . $home->data->upload_pdf)) {
                    unlink("uploads/" . $home->data->upload_pdf);
                }
            } else {
                $validatedData['upload_pdf'] = $home->data->upload_pdf ?? null;
            }
        } else if ($home->category == 'academy') {
            $request->validate(['image' => 'file|mimes:png,jpg,jpeg']);

            if ($request->file('image')) {
                $uploadedFile = $request->file('image');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path('uploads/home-images/academy');

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['image'] = "home-images/academy/" . $newFileName;

                if ($home->data != null && $home->data->image != null && file_exists("uploads/" . $home->data->image)) {
                    unlink("uploads/" . $home->data->image);
                }
            } else {
                $validatedData['image'] = $home->data->image ?? null;
            }
            $validatedData['no_telp'] = $request->no_telp;
            $validatedData['text'] = $request->text;
        } else if (\in_array($home->category, ['event', 'front-shop-1', 'front-shop-2', 'front-shop-3'])) {
            if ($home->category == 'event') {
                $pathFolder = 'home-images/event';
            } else {
                $pathFolder = 'home-images/front-shop';
            }

            $request->validate([
                'upload_image' => 'file|mimes:png,jpg,jpeg',
            ]);

            if ($request->file('upload_image')) {
                $uploadedFile = $request->file('upload_image');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path("uploads/$pathFolder");

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['image'] = "$pathFolder/" . $newFileName;

                if ($home->data != null && $home->data->image != null && file_exists("uploads/" . $home->data->image)) {
                    unlink("uploads/" . $home->data->image);
                }
            } else {
                $validatedData['image'] = $home->data->image ?? null;
            }

            if ($home->category == 'event') {
                $validatedData['event_id'] = $request->event_id;
            } else {
                $validatedData['product_id'] = $request->product_id;
            }
        } else if ($home->category == 'articles') {
            // Validasi
            $request->validate([
                'upload_image.*' => 'file|mimes:png,jpg,jpeg',
                'article_id.*' => 'required'
            ]);

            $destinationPath = public_path('uploads/');

            // initialize image upload
            $fileUploads = $request->file('upload_image');
            $articleIds = $request->article_id;
            $oldFiles = $request->oldFiles;
            $nameFiles = [];

            foreach ($articleIds as $key => $article) {
                if (isset($fileUploads[$key])) {
                    $newFileName = Str::uuid() . '-'  . $fileUploads[$key]->getClientOriginalName();
                    $fileUploads[$key]->move($destinationPath . 'home-images/article', $newFileName);
                    $validatedData[$key]['image'] = 'home-images/article/' . $newFileName;
                } else {
                    if ($request->status[$key] == 'new') {
                        $validatedData[$key]['image'] = null;
                    } else {
                        $validatedData[$key]['image'] = $oldFiles[$key];
                    }
                }
                $validatedData[$key]['article_id'] = $article;

                $nameFiles[] = $validatedData[$key]['image'];
            }

            if ($home->data) {
                foreach ($home->data as $key => $value) {
                    if (!in_array($value->image, $nameFiles)) {
                        if ($value->image != null && file_exists($destinationPath . $value->image)) {
                            unlink($destinationPath . $value->image);
                        }
                    }
                }
            }
        } else if (\in_array($home->category, ['gallery', 'gallery-review'])) {
            if ($home->category == 'gallery-review') {
                $pathFolder = 'home-images/testimoni';
            } else {
                $pathFolder = 'home-images/gallery';
            }

            $uploadedFile = $request->file('file');
            $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

            $destinationPath = public_path("uploads/$pathFolder");

            // Pindahkan file yang diunggah ke direktori tujuan
            $uploadedFile->move($destinationPath, $newFileName);

            $customMessage = $newFileName;

            if ($home->data) {
                $validatedData = $home->data;
                $validatedData[] = ['image' => "$pathFolder/$newFileName"];
            } else {
                $validatedData[] = ['image' => "$pathFolder/$newFileName"];
            }
        } else if ($home->category == 'video') {
            $uploadedFile = $request->file('file');
            $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

            $destinationPath = public_path('uploads/home-images/video');

            // Pindahkan file yang diunggah ke direktori tujuan
            $uploadedFile->move($destinationPath, $newFileName);

            $validatedData['video'] = "home-images/video/" . $newFileName;
            $customMessage = $newFileName;
        }

        HomePage::where('id', $home->id)->update(['data' => $validatedData]);
        return response()->json([
            'success' => $customMessage,
            'statusFlashMessage' => 'success',
            'textFlashMessage' => '<strong>Success,</strong> Data has been updated!'
        ], 200);
    }


    // Dropzone
    public function imageDropzone(HomePage $home)
    {
        $data = [];
        $destinationPath = public_path('uploads/');
        if ($home->category == 'gallery-review') {
            $pathFolder = 'home-images/testimoni/';
        } else if ($home->category == 'gallery') {
            $pathFolder = 'home-images/gallery/';
        }

        if ($home->category == 'video') {
            $pathFolder = 'home-images/video/';

            if (\file_exists($destinationPath . $home->data->video)) {
                $data = [
                    'name' => str_replace($pathFolder, '', $home->data->video),
                    'size' => filesize($destinationPath . $home->data->video),
                    'path' => \asset("uploads/" . $home->data->video),
                ];
            }
        } else {
            // $tableImages = [];
            foreach ($home->data as $image) {
                if (\file_exists($destinationPath . $image->image)) {
                    $data[] = [
                        'name' => str_replace($pathFolder, '', $image->image),
                        'size' => filesize($destinationPath . $image->image),
                        'path' => \asset("uploads/" . $image->image),
                    ];
                }
            }
        }
        return response()->json($data, 200);
    }

    public function destroyImageDropzone(Request $request)
    {
        $destinationPath = public_path('uploads/');

        $home = HomePage::where('category', $request->category)->first();

        if ($home->category == 'video') {
            $pathFolder = 'home-images/video';
            $filename =  "$pathFolder/$request->filename";
            if ($home->data != null && $home->data->video != null && \file_exists($destinationPath . $filename)) {
                unlink($destinationPath . $filename);
            }
            $newData = null;
        } else {
            if ($home->category == 'gallery-review') {
                $pathFolder = 'home-images/testimoni';
            } else if ($home->category == 'gallery') {
                $pathFolder = 'home-images/gallery';
            }

            $filename =  "$pathFolder/$request->filename";
            $newData = [];
            foreach ($home->data as $value) {
                if ($value->image ==  $filename && \file_exists($destinationPath . $filename)) {
                    unlink($destinationPath . $filename);
                } else {
                    $newData[] = ['image' => $value->image];
                }
            }
            $newData = ($newData === []) ? null : $newData;
        }
        HomePage::where('id', $home->id)->update(['data' => $newData]);
        return response()->json([
            'success' => '',
            'statusFlashMessage' => 'success',
            'textFlashMessage' => '<strong>Success,</strong> Data has been updated!'
        ], 200);
    }

    public function changeIsActive(Request $request, HomePage $homePage)
    {
        // return response()->json([$homePage, $request->is_active == 'true' ? 1 : 0], 200);

        HomePage::where('id', $homePage->id)->update(['is_active' => $request->is_active === 'true' ? 1 : 0]);

        return response()->json([
            'statusFlashMessage' => 'success',
            'textFlashMessage' => '<strong>Success,</strong> Data has been updated!'
        ], 200);
    }
}
