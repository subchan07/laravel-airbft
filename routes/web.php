<?php

use App\Http\Controllers\ArticleContentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Models\Article;
use App\Models\CategoryProduct;
use App\Models\HomePage;
use App\Models\MainPage;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $header = MainPage::getAllDataCustom('header');
    $categoryProducts = CategoryProduct::all();
    $homes = MainPage::getAllDataCustom('!header');

    return view('index2', compact('homes', 'header', 'categoryProducts'));
})->name('index');

Route::get('/portfolio', function () {
    $portfolio = MainPage::where('sub_page', 'portfolio')->get();
    return view('portfolio', compact('portfolio'));
});

Route::get('/about-us', function () {
    $about = MainPage::where('sub_page', 'about-us')->first();
    return view('about-us', compact('about'));
});

Route::get('/contact', function () {
    $contact = MainPage::where('sub_page', 'contact')->first();
    return view('contact', compact('contact'));
});

Route::get('/article', function () {
    $articles = Article::where('status', 'publish')->get();
    $recentPosts = Article::where('status', 'publish')->latest()->take(5)->get();
    return view('article', compact('articles', 'recentPosts'));
});

Route::get('/article/{article:slug}', function (Article $article) {
    if ($article->status == 'publish') {
        redirect('/article');
    }

    $recentPosts = Article::where('status', 'publish')->latest()->take(5)->get();
    return view('article-detail', compact('article', 'recentPosts'));
});

Route::get('/product', function () {
    $categoryProducts = CategoryProduct::all();

    if (\request('category')) {
        $category = CategoryProduct::firstWhere('slug', \request('category'));
    }

    $products = Product::with(['productImages', 'category'])->filter(request(['q', 'category']))->paginate(9)->withQueryString();
    return view('product', compact('categoryProducts', 'products'));
});

Route::get('/product/catalogue/{mainPage}', function ($mainPage) {
    $productCatalog = MainPage::where('id', $mainPage)->first();
    return view('product-catalogue', compact('productCatalog'));
})->name('product.catalogue');

Route::get('/product/{product}', function (Product $product) {
    return view('product-detail', compact('product'));
})->name('product.detail');

Route::prefix('admin')->group(function () {

    Route::get('/', function () {
        return redirect('/admin/main-page/home');
    });

    Route::controller(MainPageController::class)->group(function () {
        Route::get('/main-page/{mainPage?}', 'index')->name('main_page');
        Route::get('/main-page/create/{mainPage}', 'create')->name('main_page.create');
        Route::get('/main-page/{mainPage}/edit', 'edit')->name('main_page.edit');

        Route::post('/main-page/create', 'store')->name('main_page.store');

        Route::put('/main-page/changeIsActive/{mainPage}', 'changeIsActive')->name('main_page.changeIsActive');
        Route::put('/main-page/{mainPage}', 'update')->name('main_page.update');

        Route::delete('/main-page/{mainPage}', 'destroy')->name('main_page.destroy');
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('/product', 'index')->name('product.index');
        Route::get('/product/create', 'create')->name('product.create');
        Route::get('/product/{product}/edit', 'edit')->name('product.edit');

        Route::post('/product', 'store')->name('product.store');
        Route::post('/product/allJson', 'allJson');

        Route::put('/product/{product}', 'update')->name('product.update');
        Route::delete('/product/{product}', 'destroy')->name('product.destroy');

        Route::get('/product/image-upload/{product}', 'imageUpload')->name('product.imageUpload');
    });

    Route::controller(ProductImageController::class)->group(function () {
        Route::get('/product/image/{product}', 'getImages')->name('productImage');
        Route::post('/product/image', 'store')->name('productImage.store');
        Route::post('/product/image/destroy', 'destroy')->name('productImage.destroy');
    });

    Route::controller(ArticleController::class)->group(function () {
        Route::get('/article', 'index')->name('article.index');
        Route::get('/article/create', 'create')->name('article.create');
        Route::get('/article/{article}/edit', 'edit')->name('article.edit');

        Route::post('/article/save/{article}/{type}', 'save')->name('article.save');
        Route::post('/article', 'store')->name('article.store');
        Route::put('/article/{article}', 'update')->name('article.update');
        Route::delete('/article/{article:slug}', 'destroy')->name('article.destroy');

        Route::post('/article/cover-article/{condition}/{article}', 'coverImage')->name('article.actionCoverImage');

        Route::get('/article/data-json', 'dataJson')->name('article.json');
    });

    Route::controller(ArticleContentController::class)->group(function () {
        Route::post('/article/new-conponent-article-content', 'storeComponent')->name('articleContent.store');
        Route::put('/article/article-content/{articleContent}', 'update')->name('articleContent.update');
        Route::delete('/article/article-content/{articleContent}', 'destroy')->name('articleContent.destroy');
        Route::delete('/article/delete-conponent-article-content/{articleContent}', 'deleteComponent')->name('articleContent.delete');

        Route::get('/article/article-image/{articleContent}', 'initDropzone')->name('articleContent.initDropzone');
        Route::get('/article/article-content/data-json', 'dataJson')->name('articleContent.getJson');
    });

    Route::controller(CategoryProductController::class)->group(function () {
        Route::get('/category-product', 'index')->name('category-product.index');
        Route::get('/category-product/create', 'create')->name('category-product.create');
        Route::get('/category-product/{category}/edit', 'edit')->name('category-product.edit');
        Route::get('/category-product/dataJson', 'dataJson');

        Route::post('/category-product', 'store')->name('category-product.store');

        Route::put('/category-product/{category}', 'update')->name('category-product.update');

        Route::delete('/category-product/{category}', 'destroy')->name('category-product.destroy');
    });
});
