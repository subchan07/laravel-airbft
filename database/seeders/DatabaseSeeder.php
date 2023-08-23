<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CategoryProduct;
use App\Models\HomePage;
use App\Models\MainPage;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        // HomePage::create([
        //     'category' => 'header',
        //     'data' => ["image_desktop" => "home-images/header/de47fbe4-34ab-4e46-9aae-a5c70337d3ce-h1.jpg", "image_mobile" => "home-images/header/e894d585-03e4-48d3-a0bc-fa5844f5fd3b-h1.jpg"]
        // ]);
        // HomePage::create([
        //     'category' => 'gallery',
        //     'data' => [
        //         ["image" => "home-images/gallery/35b8403c-4313-42c3-b638-19911cf4c2af-2GufNJ8sepVn5Xzm9Pou4Q0lUpz9hzwg0VLDwQTw.jpg"],
        //         ["image" => "home-images/gallery/61814bae-b245-468b-a31d-5a558b1b96b1-3KKhlwO65TuwAiPaHozWZax5CLVawAlLyAcT8u6h.jpg"],
        //         ["image" => "home-images/gallery/45d18b22-a7d1-4f89-8273-d5b0a307d466-76Ze84uisVCQAmfjGMIrVkixE87oS7TBY0R19rCB.jpg"],
        //         ["image" => "home-images/gallery/c70c7521-88e4-4319-8a25-75ceec578a70-bZS3nxxAgVmqCBRBLP0czV2YSYCkVuMJ24Dm8g30.jpg"],
        //         ["image" => "home-images/gallery/dfaa8cb9-c11d-4c7d-b698-462437c83aa6-h0hVIOQPN5L1mv3Ch2biRU4A8MVIkaAAcroWWJ7J.jpg"],
        //         ["image" => "home-images/gallery/e8c904f3-fc0d-42c4-9cf9-8c5c5dad6f3b-JjlM3FUeKOHIx2Mgemtuc6Xn2XK52INSnM3Bj10o.jpg"],
        //         ["image" => "home-images/gallery/a397654a-71d1-4ad2-9625-00ba9d208b00-p4GIAMzbAhukjZXdyxuGRDyntSb3nAjPRGP2ZprG.jpg"],
        //         ["image" => "home-images/gallery/1f5d1065-67d7-41f0-b060-6be07aa4f14b-RduDuSnAgMe9SfDE0Sm4a5KCEicLK2GUF0iRqpYn.jpg"]
        //     ]
        // ]);
        // HomePage::create([
        //     'category' => 'articles',
        //     'data' => [
        //         ["image" => "home-images/article/425d60b4-4ec5-4a09-9351-345d29535804-h8.jpg", "article_id" => "0"],
        //         ["image" => "home-images/article/396f372b-1a14-444b-a03e-7c2f4f0d0008-h8.jpg", "article_id" => "0"],
        //         ["image" => "home-images/article/45061102-e66b-46ce-9ce8-dd2f0c4e77cf-h8.jpg", "article_id" => "0"]
        //     ]
        // ]);
        // HomePage::create([
        //     'category' => 'event',
        //     'data' => ["image" => "home-images/event/56fe75cd-5d17-42c8-92e5-da05576fe6be-h1.jpg", "event_id" => "0"]
        // ]);
        // HomePage::create([
        //     'category' => 'front-shop-1',
        //     'data' => ["image" => "home-images/front-shop/3fefeae8-9dd0-4831-a411-be87139191c8-Group 2.jpg", "product_id" => "0"]
        // ]);
        // HomePage::create([
        //     'category' => 'front-shop-2',
        //     'data' => ["image" => "home-images/front-shop/7a0529dd-b347-49d2-8ab7-b7a58740bec4-Group 1.jpg", "product_id" => "0"]
        // ]);
        // HomePage::create([
        //     'category' => 'front-shop-3',
        //     'data' => ["image" => "home-images/front-shop/f5753a05-3bea-41c7-bbb5-cf29b1a157bf-h8.jpg", "product_id" => "0"]
        // ]);
        // HomePage::create([
        //     'category' => 'video',
        //     'data' => ["video" => "home-images/video/e8f07302-6aee-43f1-8521-b0b52f5184f9-5EFe09ShcGMNUi8LEvBl9d5pZgGKotbDnSnjSmgR.mp4"]
        // ]);
        // HomePage::create([
        //     'category' => 'gallery-review',
        //     'data' => [["image" => "home-images/testimoni/a2ca279f-fece-4f84-93a5-c167889877fb-By94UNxnSJOJ3IlWjs0ktp4UuYSBGaNpC1BMkELG.jpg"]]
        // ]);
        // HomePage::create([
        //     'category' => 'academy',
        //     'data' => [
        //         "image" => "home-images/academy/e535b416-fe6f-40dd-a713-b53a95d97c6f-h1.jpg",
        //         "no_telp" => "621092310293",
        //         "text" => null
        //     ]
        // ]);
        // HomePage::create([
        //     'category' => 'product-catalog',
        //     'data' => [
        //         "upload_image" => "home-images/product-catalog/4969625b-4b1f-45e4-a161-d49f0e0c7dc5-h1.jpg",
        //         "upload_pdf" => null
        //     ]
        // ]);

        MainPage::create([
            'sub_page' => 'home',
            'category' => 'header',
            'content' => ["image" => "main-page/ab7adb04-922e-4a8f-8775-1e1665dd0f01-1.jpg", "product_id" => "0"]
        ]);
        MainPage::create([
            'sub_page' => 'home',
            'category' => 'shop',
            'content' => ["image" => "main-page/f19fdc5e-0568-41d7-badc-8bfc2bf40d3a-2.jpg", "product_id" => "0"]
        ]);
        MainPage::create([
            'sub_page' => 'home',
            'category' => 'article',
            'content' => ["image" => "main-page/4fc1711e-69bc-44cd-8d46-cbded294b635-3.jpg", "article_id" => "0"]
        ]);
        MainPage::create([
            'sub_page' => 'home',
            'category' => 'article',
            'content' => ["image" => "main-page/3645c6fe-0c00-45b7-90be-d7b2638656b3-4.jpg", "article_id" => "0"]
        ]);
        MainPage::create([
            'sub_page' => 'home',
            'category' => 'call-us-now',
            'content' => ["image" => "main-page/d8d2661c-9d9f-49ee-a053-80b0424c9419-5.jpg", "no_telp" => null, "text" => "Hello airbft"]
        ]);
        MainPage::create([
            'sub_page' => 'home',
            'category' => 'review',
            'content' => [["image" => "main-page/e704bd4d-6a17-48f2-b849-4a0b53c093be-2.1.jpg"], ["image" => "main-page/71221406-9e94-4081-82b0-630267bfabcc-2.2.jpg"], ["image" => "main-page/afa3d84d-9131-4278-bd38-e15345ec2c53-2.3.jpg"]]
        ]);
        MainPage::create([
            'sub_page' => 'home',
            'category' => 'product-catalog',
            'content' => ["image" => "main-page/fe95c0c3-3da2-41fd-a491-b4b91af89d40-6.jpg", "pdf" => null]
        ]);
        MainPage::create([
            'sub_page' => 'home',
            'category' => 'image',
            'content' => ["image" => "main-page/f8ff917e-15d8-4678-bd21-87ff3ea930a8-7.jpg"]
        ]);

        MainPage::create([
            'sub_page' => 'about-us',
            'content' => ["description" => "<h1 class=\"\"><b>About-us</b><b style=\"color: inherit; font-family: inherit; font-size: 2.5rem;\">page</b></h1>"]
        ]);
        MainPage::create([
            'sub_page' => 'portfolio',
            'content' => ["image" => "main-page/portfolio/56ce23f1-0049-4ecc-8bd1-77987df90d3f-1.1.jpg", "description" => null]
        ]);
        MainPage::create([
            'sub_page' => 'portfolio',
            'content' => ["image" => "main-page/portfolio/bdae8a21-4a1d-46fe-8202-7783d085d2a8-1.2.jpg", "description" => "<p>halo apa kabar</p>"]
        ]);
        MainPage::create([
            'sub_page' => 'contact',
            'content' => ["description" => "<h1 class=''><b>contact page</b><br></h1>"]
        ]);

        CategoryProduct::create([
            'name' => 'AIRIDE KIT',
            'slug' => 'airide-kit',
            'thumbnail' => 'product-images/category/1442a055-ef97-40e0-95e3-1dfe414306e9-1.1.jpg',
            'description' => '-',
        ]);
        CategoryProduct::create([
            'name' => 'ACCESSORIES',
            'slug' => 'accessories',
            'thumbnail' => 'product-images/category/807261d1-af15-452c-8f3d-b12114f6e506-1.2.jpg',
            'description' => '-',
        ]);
        CategoryProduct::create([
            'name' => 'CONTROLLER',
            'slug' => 'controller',
            'thumbnail' => 'product-images/category/99a970fd-8b68-4349-b28e-da47e1d052d4-1.3.jpg',
            'description' => '-',
        ]);
    }
}
