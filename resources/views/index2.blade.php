<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>“AirRide”Smart lowered airsuspension brand_AIRBFTsuspension</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">

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
    <!-- <link href="{{ asset('assets/css/style1.css') }}" rel="stylesheet" /> -->
    @vite(['public/assets/css/style1.css', 'resources/js/index2.js'])
</head>

<body>
    <!-- ======= Header ======= -->
    @include('partials.landing-page.navbar')
    <!-- End Header -->

    <main id="main">
        <!-- Hero Section - Home Page -->
        <section id="hero" class="hero button-bottom-right">

            <img loading="lazy" src="{{ asset('uploads/' . $header->content->image) }}" id="hero-bg"
                alt="Hero Bg Desktop" />

            @if ($header->content != null)
                <div class="button-bottom-right-item">
                    <a href="{{ $header->slug }}" class="button-action">BOOK NOW</a>
                </div>
            @endif
        </section>
        <!-- End Hero Section -->

        @if ($homes[0]->content != null)
            <section class="position-relative button-bottom-center">
                <img loading="lazy" src="{{ asset('uploads/' . $homes[0]->content->image) }}" class="full-width"
                    alt="Front Shop" />

                <div class="button-bottom-center-item">
                    <a href="{{ $homes[0]->slug }}" class="button-action">SHOP NOW</a>
                </div>
            </section>
        @endif

        <section class="product-category">
            <button class="scroll-button left-button">
                <i class='bx bx-chevron-left'></i> </button>
            <div class="product-category-carousel">
                <div class="product-category-carousel-inner">
                    @foreach ($categoryProducts as $product)
                        <div class="product-category-carousel-item">
                            <a href="/product?category={{ $product->slug }}">
                                <img loading="lazy" src="{{ asset('uploads/' . $product->thumbnail) }}"
                                    class="custom-card" alt="Front Shop" />
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <button class="scroll-button right-button"> <i class='bx bx-chevron-right'></i> </button>
        </section>



        {{-- <div class="d-flex flex-row ">
                @foreach ($categoryProducts as $product)
                    <a href="/product?category={{ $product->slug }}">
                        <img loading="lazy" src="{{ asset('uploads/' . $product->thumbnail) }}" class="full-width"
                            alt="Front Shop" />
                    </a>
                @endforeach
            </div> --}}

        @foreach ($homes as $key => $home)
            @if ($key > 0)
                @if ($home->content != null && $home->category == 'shop' && $home->content->image != null)
                    <section class="position-relative button-bottom-center">
                        <img loading="lazy" src="{{ asset('uploads/' . $homes->content->image) }}" class="full-width"
                            alt="Front Shop" />

                        <div class="button-bottom-center-item">
                            <a href="{{ $homes->slug }}" class="button-action">SHOP NOW</a>
                        </div>
                    </section>
                @endif
                @if ($home->content != null && $home->category == 'article' && $home->content->image != null)
                    <section class="position-relative button-center-right">
                        <img loading="lazy" src="{{ asset('uploads/' . $home->content->image) }}" class="full-width"
                            alt="Front Shop" />
                        <div class="button-center-right-item">
                            <a href="{{ $home->slug }}" class="button-action">READ MORE</a>
                        </div>
                    </section>
                @endif
                @if ($home->content != null && $home->category == 'call-us-now' && $home->content->image != null)
                    <section class="position-relative button-bottom-center">
                        <img loading="lazy" src="{{ asset('uploads/' . $home->content->image) }}" class="full-width"
                            alt="Call Us Now" />
                        <div class="button-bottom-center-item">
                            <a href="https://api.whatsapp.com/send?phone={{ $home->content->no_telp }}&text={{ $home->content->text == null ? '' : $home->content->text }}"
                                target="_blank" class="button-action">CALL US NOW</a>
                        </div>
                    </section>
                @endif
                @if ($home->content != null && $home->category == 'review')
                    <section class="review">
                        <button class="scroll-button left-button">
                            <i class='bx bx-chevron-left'></i> </button>
                        <div class="review-carousel">
                            <div class="review-carousel-inner">
                                @foreach ($home->content as $image)
                                    <div class="review-carousel-item">
                                        <img loading="lazy" src="{{ asset('uploads/' . $image->image) }}"
                                            class="full-width" alt="Review" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button class="scroll-button right-button"> <i class='bx bx-chevron-right'></i> </button>
                    </section>
                    {{-- <section class="position-relative">
                        <div class="d-flex flex-row">
                            @foreach ($home->content as $image)
                                <div>
                                    <img loading="lazy" src="{{ asset('uploads/' . $image->image) }}"
                                        class="full-width" alt="Review" />
                                </div>
                            @endforeach
                        </div>
                    </section> --}}
                @endif
                @if ($home->content != null && $home->category == 'product-catalog' && $home->content->image != null)
                    <section class="position-relative">
                        <a href="/product/catalogue/{{ $home->id }}">
                            <img loading="lazy" src="{{ asset('uploads/' . $home->content->image) }}"
                                class="full-width" alt="Product Catalog" />
                        </a>
                    </section>
                @endif
                @if ($home->content != null && $home->category == 'image' && $home->content->image != null)
                    <section class="position-relative">
                        <div>
                            <img loading="lazy" src="{{ asset('uploads/' . $home->content->image) }}"
                                class="full-width" alt="Front Shop" />
                        </div>
                    </section>
                @endif
            @endif
        @endforeach
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
