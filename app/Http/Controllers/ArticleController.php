<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleContent;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all();
        return \view('article.index', \compact('articles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_article' => 'required|max:255',
        ]);

        $validatedData = [
            'title' => $request->title_article
        ];

        Article::create($validatedData);

        $article = Article::latest()->first();
        return response()->json([
            'redirectUrl' => route('article.edit', ['article' => $article->id]),
            'statusFlashMessage' => 'success',
            'textFlashMessage' => "<strong>Success,</strong> New Article has been added!"
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return \view('article.edit', \compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $dataArticle = [
            'title' => $request->article[0]['title'],
            'tags' => $request->article[0]['tags'],
            'type' => $request->article[0]['type'],
            'status' => $request->article[0]['status']
        ];

        if ($article->published_at == null && $request->article[0]['status'] == 'publish') {
            $dataArticle['published_at'] = Carbon::now();
        }

        $slug = SlugService::createSlug(Article::class, 'slug', $dataArticle['title']);
        $dataArticle['slug'] = $dataArticle['title'] !== $article->title ? $slug : $article->slug;
        Article::where('id', $article->id)->update($dataArticle);

        if ($request->articleContent) {
            foreach ($request->articleContent as $value) {
                ArticleContent::where(['id' => $value['id']])->update(['content' => $value['value']]);
            }
        }

        return response()->json([
            'statusFlashMessage' => 'success',
            'textFlashMessage' => '<strong>Success,</strong> Data article has been updated!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $destinationPath = \public_path('uploads/');

        if (\file_exists($destinationPath . $article->cover_image)) {
            \unlink($destinationPath . $article->cover_image);
        }

        foreach ($article->articleContent as $content) {
            if ($content->type === 'picture') {
                if (\file_exists($destinationPath . $content->content)) {
                    \unlink($destinationPath . $content->content);
                }
            } else if ($content->type === 'many-pictures') {
                if ($content->content !== null) {
                    foreach (\json_decode($content->content) as  $value) {
                        if (\file_exists($destinationPath . $value)) {
                            \unlink($destinationPath . $value);
                        }
                    }
                }
            }
        }

        $article->delete();
        return response()->json([
            'statusFlashMessage' => 'success',
            'textFlashMessage' => '<strong>Success,</strong> Data article has been deleted!'
        ], 200);
    }

    public function coverImage(Request $request, $codition, Article $article)
    {
        if ($codition === 'upload') {
            $uploadedFile = $request->file('file');
            $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

            $destinationPath = public_path('uploads/article-images/cover-image');

            // Pindahkan file yang diunggah ke direktori tujuan
            $uploadedFile->move($destinationPath, $newFileName);

            $newData = "article-images/cover-image/" . $newFileName;

            $customMessage = $newFileName;
        } else if ($codition === 'delete') {
            $destinationPath = public_path('uploads/');
            $customMessage =  '';
            if ($article->cover_image ===  "article-images/cover-image/" . $request->filename && \file_exists($destinationPath . $article->cover_image)) {
                \unlink(\public_path("uploads/$article->cover_image"));
            }
            $newData = null;
        }

        Article::where('id', $article->id)->update(['cover_image' => $newData]);
        return response()->json([
            'success' => $customMessage,
            'statusFlashMessage' => 'success',
            'textFlashMessage' => "<strong>Success,</strong> Data has been" . $codition === 'upload' ? 'updated!' : 'deleted!'
        ], 200);
    }

    public function dataJson()
    {
        $destinationPath = public_path('uploads/');
        $article = '';
        if (\request('condition') === 'all') {
            $article = Article::all();
        } else if (\request('condition') === 'id') {
            $article = Article::where('id', \request('id'))->first();
        } else if (\request('condition') === 'cover-image') {
            $dataArticle = Article::where('id', \request('id'))->first();

            if (\file_exists($destinationPath . $dataArticle->cover_image)) {
                $data = [
                    'name' => \str_replace('article-images/cover-image/', '', $dataArticle->cover_image),
                    'size' => \filesize($destinationPath . $dataArticle->cover_image),
                    'path' => \asset("uploads/$dataArticle->cover_image"),
                ];
            }

            $article = $data ?? $article;
        }

        return response()->json($article, 200);
    }
}
