<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory, Sluggable;

    protected $with = ['articleContent'];
    protected $appends = ['date_publish'];

    protected $guarded = [];

    /**
     * Get all of the articleContent for the Article
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articleContent(): HasMany
    {
        return $this->hasMany(ArticleContent::class);
    }

    public function getTagsAttribute($value)
    {
        return \json_decode($value);
    }

    public function setTagsAttribute($value)
    {
        $this->attributes['tags'] = \json_encode($value);
    }

    public function getDatePublishAttribute()
    {
        $tanggalWaktu = DateTime::createFromFormat('Y-m-d H:i:s', $this->published_at);
        return $tanggalWaktu ? $tanggalWaktu->format('M d, Y') : $this->published_at;
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
