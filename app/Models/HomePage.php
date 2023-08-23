<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getDataAttribute($value)
    {
        return \json_decode($value);
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = \json_encode($value);
    }
}
