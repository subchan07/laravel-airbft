<?php

namespace Database\Seeders;

use App\Models\Website;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MainWebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Website::create([
            'title' => 'Main',
            'slug' => Str::Slug('Main'),
        ]);
    }
}
