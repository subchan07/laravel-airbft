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
    {{-- <link href="{{ asset('assets/css/style1.css') }}" rel="stylesheet" /> --}}
    @vite('public/assets/css/style1.css')
</head>

<body>
    <!-- ======= Header ======= -->
    @include('partials.landing-page.navbar')
    <!-- End Header -->

    <main id="main">
        <!-- ======= Breadcrumbs ======= -->
        <div class="banner talk">
        </div>
        <!-- End Breadcrumbs -->

        <!-- ======= Portfolio Section ======= -->
        <section id="portfolio" class="portfolio mt-5">
            <div class="container">

                <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="150">

                    @foreach ($portfolio as $p)
                        <div class="col-lg-4 col-md-6 mb-3 portfolio-item">
                            <img src="{{ asset('uploads/' . $p->content->image) }}" class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <a href="{{ asset('uploads/' . $p->content->image) }}" data-gallery="portfolioGallery"
                                    class="portfolio-lightbox preview-link" title="{{ $p->content->description }}"><i
                                        class="bx bx-zoom-in"></i></a>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
        </section><!-- End Portfolio Section -->


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
