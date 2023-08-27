<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>“AirRide”Smart lowered airsuspension brand_AIRBFTsuspension</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon" />
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style1.css') }}" rel="stylesheet" />
</head>

<body>
    <!-- ======= Header ======= -->
    @include('partials.landing-page.navbar')
    <!-- End Header -->

    <main id="main">
        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs d-flex align-items-center news-bg">
        </div>
        <!-- End Breadcrumbs -->

        <!-- ======= Blog Details Section ======= -->
        <section id="blog" class="blog">
            <div class="container" data-aos="fade-up">
                <div class="row g-5">
                    <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
                        <article class="blog-details">
                            <div class="blog-header">
                                <small class="breadcrumb">
                                    <span><span><a href="/article">article</a></span>
                                        <span class="breadcrumb_last">
                                            {{ $article->title }}
                                        </span></span>
                                </small>
                                <h2 class="title">
                                    {{ $article->title }}
                                </h2>
                                <ol>
                                    <li>Posted by admin</li>
                                    <li>{{ $article->date_publish }}</li>
                                </ol>
                            </div>

                            <div class="post-img">
                                <img src="{{ asset('uploads/' . $article->cover_image) }}" alt="" class="img-fluid" />
                            </div>

                            <div class="content">
                                @foreach ($article->articleContent as $content)
                                    @if ($content->type == 'description')
                                        {!! $content->content !!}
                                    @else
                                        @if ($content->type == 'picture')
                                            <img src="{{ asset('uploads/' . $content->content) }}" width="100%" class="mb-3 img-fluid"
                                                alt="">
                                        @else
                                            @foreach (json_decode($content->content) as $item)
                                                <img src="{{ asset('uploads/' . $item) }}" width="100%" class=" mb-3 img-fluid" alt="">
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach

                            </div>
                    </div>

                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
                        <div class="sidebar ps-lg-4">
                            {{-- <div class="sidebar-item search-form">
                                <h3 class="sidebar-title">Search</h3>
                                <form action="" class="mt-3">
                                    <input type="search" />
                                    <button type="submit"><i class="bi bi-search"></i></button>
                                </form>
                            </div> --}}
                            <!-- End sidebar search formn-->

                            @if ($recentPosts->count())
                                <div class="sidebar-item recent-posts">
                                    <h3 class="sidebar-title">Recent Posts</h3>

                                    <div class="mt-3">
                                        @foreach ($recentPosts as $recent)
                                            <div class="post-item mt-3">
                                                <img src="{{ asset('uploads/' . $recent->cover_image) }}" alt="" class="flex-shrink-0" />
                                                <div>
                                                    <h4>
                                                        <a href="/article/{{ $recent->slug }}"
                                                            title="{{ $recent->title }}">{{ $recent->title }}</a>
                                                    </h4>
                                                    <!-- <p class="time">Jan 1, 2020</p> -->
                                                </div>
                                            </div>
                                            <!-- End recent post item-->
                                        @endforeach

                                    </div>
                                </div>
                            @endif

                            <!-- End sidebar recent posts-->

                            <div class="sidebar-item tags">
                                <h3 class="sidebar-title">Tags</h3>
                                <ul class="mt-3">
                                    <li><a href="#">App</a></li>
                                    <li><a href="#">Business</a></li>
                                    <li><a href="#">Mac</a></li>
                                    <li><a href="#">Design</a></li>
                                    <li><a href="#">Office</a></li>
                                    <li><a href="#">Creative</a></li>
                                    <li><a href="#">Studio</a></li>
                                    <li><a href="#">Smart</a></li>
                                    <li><a href="#">Tips</a></li>
                                    <li><a href="#">Marketing</a></li>
                                </ul>
                            </div>
                            <!-- End sidebar tags-->
                        </div>
                        <!-- End Blog Sidebar -->
                    </div>
                </div>
            </div>
        </section>
        <!-- End Blog Details Section -->
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    @include('partials.landing-page.footer')
    <!-- End Footer -->

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main1.js') }}"></script>
</body>

</html>
