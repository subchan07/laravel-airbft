<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug'
    ];

    public function pages()
    {
        return $this->hasMany(MainPage::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($parent) {
            foreach ($parent->pages as $page) {
                if ($page->category !== 'review') {
                    $filePath = public_path('uploads/' . $page->content->image);
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                } else {
                    $paths = $page->content;
                    foreach ($paths as $path) {
                        $filePath = public_path('uploads/' . $path->image);
                        if (File::exists($filePath)) {
                            File::delete($filePath);
                        }
                    }
                }

                $page->delete();
            }
        });
    }
}
