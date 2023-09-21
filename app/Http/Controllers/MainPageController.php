<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\MainPage;
use App\Models\Product;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MainPageController extends Controller
{
    public function index($mainPage, Website $website)
    {
        $title = $mainPage;
        $site = $website->slug;
        if ($mainPage === 'home') {
            $mainPages = $website->pages()->where('sub_page', $mainPage)->get();
        } else {
            $mainPages = MainPage::where('sub_page', $mainPage)->where('website_id', 1)->get();
        }
        // dd($mainPages2);
        return \view('main_page.index', \compact('mainPages', 'title', 'site', 'website'));
    }

    public function create($mainPage, Website $website)
    {
        if ($mainPage == 'about-us' || $mainPage == 'contact') {
            \abort(404);
        } else if ($mainPage == 'portfolio') {
            $title = 'New Portfolio';
            return \view('main_page.portfolio.create', \compact('title', 'mainPage', 'website'));
        } else if ($mainPage == 'shop') {
            $title = 'New Shop';
            $products = Product::all();
            return \view('main_page.home.shop.create', \compact('title', 'mainPage', 'products', 'website'));
        } else if ($mainPage == 'article') {
            $title = 'New Article';
            $articles = Article::where('status', 'publish')->get();
            return \view('main_page.home.article.create', \compact('title', 'mainPage', 'articles', 'website'));
        } else if ($mainPage == 'call-us-now') {
            $title = 'New Call Us Now';
            return \view('main_page.home.call-us.create', \compact('title', 'mainPage', 'website'));
        } else if ($mainPage == 'image') {
            $title = 'New Image';
            return \view('main_page.home.image.create', \compact('title', 'mainPage', 'website'));
        } else if ($mainPage == 'product-catalog') {
            $title = 'New Product Catalog';
            return \view('main_page.home.catalog.create', \compact('title', 'mainPage', 'website'));
        } else if ($mainPage == 'review') {
            $title = 'New Review';
            return \view('main_page.home.review.create', \compact('title', 'mainPage', 'website'));
        } else if ($mainPage == 'popup-promo') {
            $title = 'New Popup Promo';
            $products = Product::all();
            return view('main_page.home.popup-promo.create', compact('title', 'mainPage', 'website', 'products'));
        }
    }

    public function store(Request $request, Website $website)
    {

        $data = [];
        if ($request->category == 'about-us') {
            \abort(404);
        } else if ($request->category == 'shop') {
            $validatedData = $request->validate([
                'upload_image' => 'image|file|mimes:png,jpg,jpeg',
                'product_id' => 'required'
            ]);

            if ($request->file('upload_image')) {
                $uploadedFile = $request->file('upload_image');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path('uploads/main-page');

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['upload_image'] = "main-page/" . $newFileName;
            } else {
                $validatedData['upload_image'] = null;
            }

            $data = [
                'sub_page' => 'home',
                'category' => $request->category,
                'content' => [
                    'image' => $validatedData['upload_image'],
                    'product_id' => $request->product_id
                ],
                'is_active' => true
            ];
        } else if ($request->category == 'article') {
            $validatedData = $request->validate([
                'upload_image' => 'image|file|mimes:png,jpg,jpeg',
                'article_id' => 'required'
            ]);

            if ($request->file('upload_image')) {
                $uploadedFile = $request->file('upload_image');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path('uploads/main-page');

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['upload_image'] = "main-page/" . $newFileName;
            } else {
                $validatedData['upload_image'] = null;
            }

            $data = [
                'sub_page' => 'home',
                'category' => $request->category,
                'content' => [
                    'image' => $validatedData['upload_image'],
                    'article_id' => $request->article_id
                ],
                'is_active' => true
            ];
        } else if ($request->category == 'call-us-now') {
            $validatedData = $request->validate([
                'upload_image' => 'image|file|mimes:png,jpg,jpeg',
                'no_telp' => 'required',
                'text' => 'required',
            ]);

            if ($request->file('upload_image')) {
                $uploadedFile = $request->file('upload_image');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path('uploads/main-page');

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['upload_image'] = "main-page/" . $newFileName;
            } else {
                $validatedData['upload_image'] = null;
            }

            $data = [
                'sub_page' => 'home',
                'category' => $request->category,
                'content' => [
                    'image' => $validatedData['upload_image'],
                    'no_telp' => $request->no_telp,
                    'text' => $request->text
                ],
                'is_active' => true
            ];
        } else if ($request->category == 'product-catalog') {
            $validatedData = $request->validate([
                'upload_image' => 'image|file|mimes:png,jpg,jpeg',
                'upload_pdf' => 'file|mimes:pdf',
            ]);

            if ($request->file('upload_image')) {
                $uploadedFile = $request->file('upload_image');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path('uploads/main-page');

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['upload_image'] = "main-page/" . $newFileName;
            } else {
                $validatedData['upload_image'] = null;
            }

            if ($request->file('upload_pdf')) {
                $uploadedFile = $request->file('upload_pdf');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path('uploads/main-page');

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['upload_pdf'] = "main-page/" . $newFileName;
            } else {
                $validatedData['upload_pdf'] = null;
            }

            $data = [
                'sub_page' => 'home',
                'category' => $request->category,
                'content' => [
                    'image' => $validatedData['upload_image'],
                    'pdf' => $validatedData['upload_pdf'],
                ],
                'is_active' => true
            ];
        } else if ($request->category == 'image') {
            $validatedData = $request->validate([
                'upload_image' => 'image|file|mimes:png,jpg,jpeg',
            ]);

            if ($request->file('upload_image')) {
                $uploadedFile = $request->file('upload_image');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path('uploads/main-page');

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['upload_image'] = "main-page/" . $newFileName;
            } else {
                $validatedData['upload_image'] = null;
            }

            $data = [
                'sub_page' => 'home',
                'category' => $request->category,
                'content' => [
                    'image' => $validatedData['upload_image'],
                ],
                'is_active' => true
            ];
        } else if ($request->category == 'review') {
            $request->validate([
                'upload_image.*' => 'image|file|mimes:png,jpg,jpeg',
            ]);

            $validatedData = ['main-page....'];
            $fileUploads = $request->file('upload_image');
            if ($fileUploads) {
                foreach ($fileUploads as $key => $value) {
                    if ($fileUploads[$key]) {
                        $uploadedFile = $fileUploads[$key];
                        $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                        $destinationPath = public_path('uploads/main-page');

                        // Pindahkan file yang diunggah ke direktori tujuan
                        $uploadedFile->move($destinationPath, $newFileName);

                        $validatedData[] = "main-page/" . $newFileName;
                    } else {
                        $validatedData[] = null;
                    }
                }
            }
            $data = [
                'sub_page' => 'home',
                'category' => $request->category,
                'content' => [
                    'image' => $validatedData,
                ],
                'is_active' => true
            ];
        } else if ($request->category == 'portfolio') {
            $validatedData = $request->validate([
                'thumbnail' => 'image|file|mimes:png,jpg,jpeg',
                'description' => 'required'
            ]);

            if ($request->file('thumbnail')) {
                $uploadedFile = $request->file('thumbnail');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path('uploads/main-page/portfolio');

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['thumbnail'] = "main-page/portfolio/" . $newFileName;
            } else {
                $validatedData['thumbnail'] = null;
            }

            $data = [
                'sub_page' => $request->category,
                'content' => [
                    'image' => $validatedData['thumbnail'],
                    'description' => $request->description
                ],
                'is_active' => true
            ];
        } else if ($request->category == 'popup-promo') {
            $data = [];

            $validated = $request->validate([
                'time' => ['required'],
                'product' => ['required'],
                'upload_image' => ['image', 'mimes:png,jpg,jpeg'],
                'category' => ['required']
            ]);

            $data['sub_page'] = 'home';
            $data['category'] = $validated['category'];

            $content = [];
            if ($request->hasFile('upload_image')) {
                $uploadedFile = $request->file('upload_image');
                $fileName = Str::uuid() . '-' . $uploadedFile->getClientOriginalName();
                $destinationPath = public_path('uploads/main-page/' . $fileName);
                $uploadedFile->move(public_path('uploads/main-page/'), $fileName);
                $content['image'] = 'main-page/' . $fileName;
            } else {
                $content['image'] = null;
            }
            $content['time'] = $validated['time'];
            $content['product_id'] = $validated['product'];
            $data['content']  = $content;
            $data['website_id'] = $website->id;
            $data['is_active'] = true;
        }

        // MainPage::create($data);
        $website->pages()->create($data);

        return response()->json([
            'statusFlashMessage' => 'success',
            'textFlashMessage' => "<strong>Success,</strong> New $request->category has been added!"
        ], 200);
    }

    public function edit(MainPage $mainPage)
    {
        if ($mainPage->sub_page == 'about-us' || $mainPage->sub_page == 'contact') {
            $title = 'Edit ' . $mainPage->sub_page;
            return \view('main_page.about-us.edit', \compact('title', 'mainPage'));
        } else  if ($mainPage->sub_page == 'portfolio') {
            $title = 'Edit Portfolio';
            return \view('main_page.portfolio.edit', \compact('title', 'mainPage'));
        } else if ($mainPage->sub_page == 'home' &&  $mainPage->category == 'header') {
            $title = 'Edit Header';
            $products = Product::all();
            return \view('main_page.home.header', \compact('title', 'mainPage', 'products'));
        } else if ($mainPage->sub_page == 'home' &&  $mainPage->category == 'shop') {
            $title = 'Edit Shop';
            $products = Product::all();
            return \view('main_page.home.shop.edit', \compact('title', 'mainPage', 'products'));
        } else if ($mainPage->sub_page == 'home' &&  $mainPage->category == 'article') {
            $title = 'Edit Article';
            $articles = Article::where('status', 'publish')->get();
            return \view('main_page.home.article.edit', \compact('title', 'mainPage', 'articles'));
        } else if ($mainPage->sub_page == 'home' &&  $mainPage->category == 'call-us-now') {
            $title = 'Edit Call Us Now';
            return \view('main_page.home.call-us.edit', \compact('title', 'mainPage'));
        } else if ($mainPage->sub_page == 'home' &&  $mainPage->category == 'image') {
            $title = 'Edit Image';
            return \view('main_page.home.image.edit', \compact('title', 'mainPage'));
        } else if ($mainPage->sub_page == 'home' &&  $mainPage->category == 'product-catalog') {
            $title = 'Edit Product Catalog';
            return \view('main_page.home.catalog.edit', \compact('title', 'mainPage'));
        } else if ($mainPage->sub_page == 'home' &&  $mainPage->category == 'review') {
            $title = 'Edit Review';
            return \view('main_page.home.review.edit', \compact('title', 'mainPage'));
        } else if ($mainPage->sub_page == 'home' && $mainPage->category == 'popup-promo') {
            $title = 'Edit Popup Promo';
            $products = Product::all();

            return view('main_page.home.popup-promo.edit', compact('title', 'mainPage', 'products'));
        }
    }

    public function update(Request $request, MainPage $mainPage)
    {
        $data = [];
        if ($mainPage->sub_page == 'about-us' || $mainPage->sub_page == 'contact') {
            $request->validate([
                'description' => 'required'
            ]);
            $data = [
                'content' => [
                    'description' => $request->description
                ],
            ];
        } else if ($mainPage->sub_page == 'portfolio') {
            $validatedData = $request->validate([
                'thumbnail' => 'image|file|mimes:png,jpg,jpeg',
            ]);

            if ($request->file('thumbnail')) {
                $uploadedFile = $request->file('thumbnail');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path('uploads/main-page/portfolio');

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['thumbnail'] = "main-page/portfolio/" . $newFileName;

                if ($mainPage->content != null && $mainPage->content->image != null && \file_exists(\public_path('uploads/') . $mainPage->content->image)) {
                    \unlink(\public_path('uploads/') . $mainPage->content->image);
                }
            } else {
                $validatedData['thumbnail'] = $mainPage->content->image ?? null;
            }

            $data = [
                'content' => [
                    'image' => $validatedData['thumbnail'],
                    'description' => $request->description
                ],
            ];
        } else if ($mainPage->category == 'shop' || $mainPage->category == 'header') {
            $validatedData = $request->validate([
                'upload_image' => 'image|file|mimes:png,jpg,jpeg',
                'product_id' => 'required'
            ]);

            if ($request->file('upload_image')) {
                $uploadedFile = $request->file('upload_image');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path('uploads/main-page');

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['upload_image'] = "main-page/" . $newFileName;

                if ($mainPage->content != null && $mainPage->content->image != null && \file_exists(\public_path("uploads/" . $mainPage->content->image))) {
                    \unlink(\public_path("uploads/" . $mainPage->content->image));
                }
            } else {
                $validatedData['upload_image'] = $mainPage->content->image ?? null;
            }

            $data = [
                'content' => [
                    'image' => $validatedData['upload_image'],
                    'product_id' => $request->product_id
                ]
            ];
        } else if ($mainPage->category == 'article') {
            $validatedData = $request->validate([
                'upload_image' => 'image|file|mimes:png,jpg,jpeg',
                'article_id' => 'required'
            ]);

            if ($request->file('upload_image')) {
                $uploadedFile = $request->file('upload_image');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path('uploads/main-page');

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['upload_image'] = "main-page/" . $newFileName;

                if ($mainPage->content != null && $mainPage->content->image != null && \file_exists(\public_path("uploads/" . $mainPage->content->image))) {
                    \unlink(\public_path("uploads/" . $mainPage->content->image));
                }
            } else {
                $validatedData['upload_image'] = $mainPage->content->image ?? null;
            }

            $data = [
                'content' => [
                    'image' => $validatedData['upload_image'],
                    'article_id' => $request->article_id
                ]
            ];
        } else if ($mainPage->category == 'call-us-now') {
            $validatedData = $request->validate([
                'upload_image' => 'image|file|mimes:png,jpg,jpeg',
            ]);

            if ($request->file('upload_image')) {
                $uploadedFile = $request->file('upload_image');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path('uploads/main-page');

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['upload_image'] = "main-page/" . $newFileName;

                if ($mainPage->content != null && $mainPage->content->image != null && \file_exists(\public_path("uploads/" . $mainPage->content->image))) {
                    \unlink(\public_path("uploads/" . $mainPage->content->image));
                }
            } else {
                $validatedData['upload_image'] = $mainPage->content->image ?? null;
            }

            $data = [
                'content' => [
                    'image' => $validatedData['upload_image'],
                    'no_telp' => $request->no_telp,
                    'text' => $request->text
                ]
            ];
        } else if ($mainPage->category == 'product-catalog') {
            $validatedData = $request->validate([
                'upload_image' => 'image|file|mimes:png,jpg,jpeg',
                'upload_pdf' => 'file|mimes:pdf',
            ]);

            if ($request->file('upload_image')) {
                $uploadedFile = $request->file('upload_image');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path('uploads/main-page');

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['upload_image'] = "main-page/" . $newFileName;

                if ($mainPage->content != null && $mainPage->content->image != null && \file_exists(\public_path("uploads/" . $mainPage->content->image))) {
                    \unlink(\public_path("uploads/" . $mainPage->content->image));
                }
            } else {
                $validatedData['upload_image'] = $mainPage->content->image ?? null;
            }

            if ($request->file('upload_pdf')) {
                $uploadedFile = $request->file('upload_pdf');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path('uploads/main-page');

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['upload_pdf'] = "main-page/" . $newFileName;

                if ($mainPage->content != null && $mainPage->content->pdf != null && \file_exists(\public_path("uploads/" . $mainPage->content->pdf))) {
                    \unlink(\public_path("uploads/" . $mainPage->content->pdf));
                }
            } else {
                $validatedData['upload_pdf'] = $mainPage->content->pdf ?? null;
            }

            $data = [
                'content' => [
                    'image' => $validatedData['upload_image'],
                    'pdf' => $validatedData['upload_pdf'],
                ]
            ];
        } else if ($mainPage->category == 'image') {
            $validatedData = $request->validate([
                'upload_image' => 'image|file|mimes:png,jpg,jpeg',
            ]);

            if ($request->file('upload_image')) {
                $uploadedFile = $request->file('upload_image');
                $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                $destinationPath = public_path('uploads/main-page');

                // Pindahkan file yang diunggah ke direktori tujuan
                $uploadedFile->move($destinationPath, $newFileName);

                $validatedData['upload_image'] = "main-page/" . $newFileName;

                if ($mainPage->content != null && $mainPage->content->image != null && \file_exists(\public_path("uploads/" . $mainPage->content->image))) {
                    \unlink(\public_path("uploads/" . $mainPage->content->image));
                }
            } else {
                $validatedData['upload_image'] = $mainPage->content->image ?? null;
            }

            $data = [
                'content' => [
                    'image' => $validatedData['upload_image'],
                ]
            ];
        } else if ($mainPage->category == 'review') {
            $request->validate([
                'upload_image.*' => 'required|image|file|mimes:png,jpg,jpeg',
            ]);

            $validatedData = [];
            $fileUploads = $request->file('upload_image');
            $oldFileUploads = $request->oldFiles;
            foreach ($oldFileUploads as $key => $value) {
                if (isset($fileUploads[$key])) {
                    $uploadedFile = $fileUploads[$key];
                    $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

                    $destinationPath = public_path('uploads/main-page');

                    // Pindahkan file yang diunggah ke direktori tujuan
                    $uploadedFile->move($destinationPath, $newFileName);

                    $validatedData[$key]['image'] = "main-page/" . $newFileName;

                    if ($mainPage->content != null && $mainPage->content[$key]->image && \file_exists(\public_path("uploads/" . $mainPage->content[$key]->image))) {
                        \unlink(\public_path("uploads/" . $mainPage->content[$key]->image));
                    }
                } else {
                    $validatedData[$key]['image'] = $oldFileUploads[$key] ?? null;
                }
            }

            $data = [
                'content' => $validatedData
            ];
        } else if ($mainPage->category == 'popup-promo') {
            $data = [];
            $content = [];
            $validated = $request->validate([
                'time' => ['required'],
                'product' => ['required'],
                'upload_image' => ['image', 'mimes:png,jpg,jpeg'],
                'category' => ['required']
            ]);

            if ($request->hasFile('upload_image')) {
                if (File::exists(public_path('uploads/' . $mainPage->content->image))) {
                    File::delete(public_path('uploads/' . $mainPage->content->image));
                }
                $file = $request->file('upload_image');
                $filename = Str::uuid() . '-' . $file->getClientOriginalName();
                $destinationPath = public_path('uploads/main-page/');
                $file->move($destinationPath, $filename);
                $content['image'] = 'main-page/' . $filename;
            } else {
                $content['image'] = $mainPage->content->image;
            }

            $content['time'] = $validated['time'];
            $content['product_id'] = $validated['product'];
            $data['content'] = $content;
        }

        MainPage::where('id', $mainPage->id)->update($data);

        return response()->json([
            'statusFlashMessage' => 'success',
            'textFlashMessage' => "<strong>Success,</strong> $mainPage->category has been updated!"
        ], 200);
    }

    public function destroy(MainPage $mainPage)
    {
        if ($mainPage->sub_page == 'portfolio') {
            if ($mainPage->content != null && $mainPage->content->image != null && \file_exists(\public_path('uploads/') . $mainPage->content->image)) {
                \unlink(\public_path('uploads/') . $mainPage->content->image);
            }
            $mainPage->delete();
        }
        return response()->json([
            'statusFlashMessage' => 'success',
            'textFlashMessage' => '<strong>Success,</strong> Data has been deleted!'
        ], 200);
    }

    public function changeIsActive(Request $request, MainPage $mainPage)
    {
        MainPage::where('id', $mainPage->id)->update(['is_active' => $request->is_active === 'true' ? true : false]);

        return response()->json([
            'statusFlashMessage' => 'success',
            'textFlashMessage' => '<strong>Success,</strong> Data has been updated!'
        ], 200);
    }

    public function pageSize()
    {
        return $this->belongsTo(Website::class);
    }
}
