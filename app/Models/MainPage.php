<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainPage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getContentAttribute($value)
    {
        return \json_decode($value);
    }

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = \json_encode($value);
    }

    static public function getAllDataCustom($category, $website)
    {
        if ($category == 'header') {
            $home = MainPage::where('sub_page', 'home')->where('category', 'header')->where('website_id', $website)->first();
            $data = $home;
            if ($home->content != null && $home->content->product_id != 0) {
                $product = Product::where('id', $home->content->product_id)->with('category')->first();
                $data['slug'] = "/product/$product->slug";
            } else {
                $data['slug'] = 'javascript:;';
            }
        } else if ($category == '!header') {
            $homes = MainPage::where('sub_page', 'home')->where('category', '!=', 'header')->where('website_id', $website)->get();
            $data = [];
            foreach ($homes as $key => $home) {
                $data[] = $home;
                if ($home->category == 'shop') {
                    if ($home->content != null && $home->content->product_id != 0) {
                        $product = Product::where('id', $home->content->product_id)->with('category')->first();
                        $data[$key]['slug'] = "/product/$product->slug";
                    } else {
                        $data[$key]['slug'] = 'javascript:;';
                    }

                    // if ($home->content != null && $home->content->image && \file_exists(\public_path("uploads/" . $home->content->image))) {
                    //     $data[$key]['image'] = $home->content->image;
                    // } else {
                    //     $data[$key]['image'] = "https://placehold.co/600x400?text=No+Image";
                    // }
                } else if ($home->category == 'article') {
                    if ($home->content != null && $home->content->article_id != 0) {
                        $article = Article::where('id', $home->content->article_id)->first();
                        $data[$key]['slug'] = "/article/$article->slug";
                    } else {
                        $data[$key]['slug'] = 'javascript:;';
                    }
                }
            }
        }

        return $data;
    }
    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
