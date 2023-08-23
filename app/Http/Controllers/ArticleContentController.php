<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleContent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleContentController extends Controller
{

    public function initDropzone(ArticleContent $articleContent)
    {
        $destinationPath = public_path('uploads/');
        $data = [];
        if ($articleContent->type === 'picture') {
            if (\file_exists($destinationPath . $articleContent->content)) {
                $data = [
                    'name' => str_replace('article-images/', '', $articleContent->content),
                    'size' => filesize($destinationPath . $articleContent->content),
                    'path' => \asset("uploads/" . $articleContent->content),
                ];
            }
        } else if ($articleContent->type === 'many-pictures') {
            foreach (\json_decode($articleContent->content) as $image) {
                if (\file_exists($destinationPath . $image)) {
                    $data[] = [
                        'name' => str_replace('article-images/', '', $image),
                        'size' => filesize($destinationPath . $image),
                        'path' => \asset("uploads/" . $image),
                    ];
                }
            }
        }

        return response()->json($data, 200);
    }

    public function update(Request $request, ArticleContent $articleContent)
    {
        $customMessage = '';

        if ($articleContent->type === 'picture') {
            $uploadedFile = $request->file('file');
            $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

            $destinationPath = public_path('uploads/article-images');

            // Pindahkan file yang diunggah ke direktori tujuan
            $uploadedFile->move($destinationPath, $newFileName);

            $validatedData = "article-images/" . $newFileName;

            $customMessage = $newFileName;
        } else if ($articleContent->type === 'many-pictures') {
            $validatedData = [];

            $uploadedFile = $request->file('file');
            $newFileName = Str::uuid() . '-'  . $uploadedFile->getClientOriginalName();

            $destinationPath = public_path('uploads/article-images');

            // Pindahkan file yang diunggah ke direktori tujuan
            $uploadedFile->move($destinationPath, $newFileName);

            if ($articleContent->content) {
                $validatedData = \json_decode($articleContent->content);
            }

            $customMessage = $newFileName;
            $validatedData[] =  "article-images/" . $newFileName;
        }

        ArticleContent::where('id', $articleContent->id)->update(['content' => $validatedData]);

        return response()->json([
            'success' => $customMessage,
            'statusFlashMessage' => 'success',
            'textFlashMessage' => '<strong>Success,</strong> Data has been updated!'
        ], 200);
    }

    public function destroy(Request $request, ArticleContent $articleContent)
    {
        $destinationPath = public_path('uploads/');
        $filename =  $request->filename;

        if ($articleContent->type === 'picture') {
            if ($articleContent->content ===  "article-images/" . $filename && \file_exists($destinationPath . $articleContent->content)) {
                \unlink($destinationPath . $articleContent->content);
            }
            $newData = null;
        } else if ($articleContent->type === 'many-pictures') {
            $newData = [];
            foreach (\json_decode($articleContent->content) as $value) {
                if ($value ==  "article-images/" . $filename && \file_exists($destinationPath . $value)) {
                    \unlink($destinationPath . $value);
                } else {
                    $newData[] = $value;
                }
            }
            $newData = ($newData === []) ? null : $newData;
        }

        ArticleContent::where('id', $articleContent->id)->update(['content' => $newData]);
        return response()->json([
            'success' => '',
            'statusFlashMessage' => 'success',
            'textFlashMessage' => '<strong>Success,</strong> Data has been updated!'
        ], 200);
    }

    public function storeComponent(Request $request)
    {
        $type = $request->type;
        $articleId = $request->article_id;

        ArticleContent::create(['article_id' => $articleId, 'type' => $type]);
        $articleContent = ArticleContent::latest()->first();

        return response()->json(['id' => $articleContent->id, 'type' => $articleContent->type], 200);
    }

    public function deleteComponent(ArticleContent $articleContent)
    {
        $destinationPath = public_path('uploads/');

        if ($articleContent->type === 'picture') {
            if ($articleContent->content != null && \file_exists($destinationPath . $articleContent->content)) {
                \unlink($destinationPath . $articleContent->content);
            }
        } else if ($articleContent->type === 'many-pictures') {
            if ($articleContent->content !== null) {
                foreach (\json_decode($articleContent->content) as  $value) {
                    if (\file_exists($destinationPath . $value)) {
                        \unlink($destinationPath . $value);
                    }
                }
            }
        }

        $articleContent->delete();
        return response()->json([
            'statusFlashMessage' => 'success',
            'textFlashMessage' => '<strong>Success,</strong> Data has been deleted!'
        ], 200);
    }

    public function dataJson()
    {
        $dataArticleContent = '';
        if (\request('condition') === 'all') {
            $dataArticleContent = ArticleContent::all();
        } else if (\request('condition') === 'parent') {
            $dataArticleContent = ArticleContent::where('article_id', \request('id'))->get();
        } else if (\request('condition') === 'id') {
            $dataArticleContent = ArticleContent::where('id', \request('id'))->first();
        }

        return response()->json($dataArticleContent, 200);
    }
}
