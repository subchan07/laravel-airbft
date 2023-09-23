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

    {{-- Leaflet Library --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>


    <!-- Template Main CSS File -->
    @vite(['public/assets/css/style1.css', 'resources/js/index2.js','resources/css/app.css','resources/js/main.ts'])
</head>

<body>
    <!-- ======= Header ======= -->
    @include('partials.landing-page.navbar')
    <!-- End Header -->

    <main id="main">
        <!-- Hero Section - Home Page -->
        <section id="hero" class="hero button-center-right">

            <img loading="lazy" src="{{ asset('uploads/' . $header->content->image) }}" id="hero-bg"
                alt="Hero Bg Desktop" />

            @if ($header->content != null)
                <div class="button-center-right-item">
                    <a href="{{ $header->slug }}" class="button-action">BOOK NOW</a>
                </div>
            @endif
        </section>
        <!-- End Hero Section -->

        @if ($homes[0]->content != null)
            <section class="position-relative button-bottom-center">
                <img loading="lazy" src="{{ asset('uploads/' . $homes[0]->content->image) }}" class="full-width"
                    alt="Front Shop" />

                <div class="button-center-center-item">
                    <a href="{{ $homes[0]->slug }}" class="button-action">SHOP NOW</a>
                </div>
            </section>
        @endif

        <section class="product-category">
            <div class="background-container"></div>
            <button class="scroll-button left-button">
                <i class='bx bx-chevron-left'></i> </button>
            <div class="product-category-carousel">
                <div class="product-category-carousel-inner">
                    @foreach ($categoryProducts as $product)
                        <div class="product-category-carousel-item">
                            <a href="/product?category={{ $product->slug }}" class="image-container">
                                <img loading="lazy" src="{{ asset('uploads/' . $product->thumbnail) }}"
                                    class="custom-card img" alt="Front Shop" />
                                <img loading="lazy"
                                    src="{{ asset('uploads/' . ($product->hover_thumbnail ?: $product->thumbnail)) }}"
                                    class="img-hover custom-card" alt="Hover Product">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <button class="scroll-button right-button"> <i class='bx bx-chevron-right'></i> </button>
        </section>



        {{-- <div class="flex-row d-flex ">
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
                        <img loading="lazy" src="{{ asset('uploads/' . $home->content->image) }}" class="full-width"
                            alt="Front Shop" />

                        <div class="button-bottom-center-item">
                            <a href="{{ $home->slug }}" class="button-action">SHOP NOW</a>
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
                @if ($home->content != null && $home->category == 'review')
                    <section class="review">
                        <div class="background-container"></div>
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
                        <div class="flex-row d-flex">
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
            @endif
        @endforeach
        @foreach ($homes as $key => $home)
            @if ($key > 0)
                @if ($home->content != null && $home->category == 'call-us-now' && $home->content->image != null)
                    <section class="position-relative button-bottom-right with-map-section">
                        <section id="map" class="map-container"></section>
                        <img loading="lazy" src="{{ asset('uploads/' . $home->content->image) }}"
                            class="overlay-img" alt="Call Us Now" />
                        <div class="overlay-button">
                            <a href="https://api.whatsapp.com/send?phone={{ $home->content->no_telp }}&text={{ $home->content->text == null ? '' : $home->content->text }}"
                                target="_blank" class="button-action">CALL US NOW</a>
                        </div>
                    </section>
                @endif
            @endif
        @endforeach
        @foreach ($homes as $key => $home)
            @if ($key > 0)
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
    @foreach ($homes as $home)
        @if ($home->category != null && $home->category == 'popup-promo' && $home->content->image != null)
        <section class="popup-promo-container">                
                <div class="popup-promo">
                    <a href="{{ $home->slug }}">

                        <img src="{{ asset('uploads/' . $home->content->image) }}" class="promo-image"
                            alt="Promo image">
                    </a>
                    <button data-id="promo-close-btn" class="close-btn">
                        &times;
                    </button>
                   <div class="countdown" draggable="false">
                        <div class="timer-container" data-date="{{ $home->content->date }}" data-time="{{ $home->content->time }}">
                            <span class="timer-title">OFFER END IN</span>
                            <div class="time"><span class="hour">00</span><span class="timer-format">HRS</span></div>
                            <div class="time"><span class="minute">00</span><span class="timer-format">MIN</span></div>
                            <div class="time"><span class="second">00</span><span class="timer-format">SEC</span></div>            
                            <span class="offer-end hidden">OFFER ENDED</span>                
                        </div>
                        <a href="{{ $home->slug }}" class="buy-now">BELI SEKARANG!!</a>
                   </div>
                </div>
            </section>
        @endif
    @endforeach
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
    <script>
        let map = L.map('map').setView([0.9501741991682735, 125.54395799208935], 4);

        // L.tileLayer(
        //     'https://{s}.tile.thunderforest.com/landscape/{z}/{x}/{y}.png?apikey=7a69abaa00584a99a5c856ddfad442c5', {
        //         attribution: '&copy; <a href="https://www.thunderforest.com/maps/landscape/">Thunderforest</a> contributors'
        //     }).addTo(map);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 18, // Set the maximum zoom level to 18
            minZoom: 1,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        let redIcon = L.icon({
            iconUrl: '{{ asset('assets/img/23-230399_google-maps-pin-png-red-map-marker.png') }}',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
        });

        const locations = [{
                name: 'PLATINUM AUTOWORKSHOP',
                address: `Jl. Raya Batusangkar No 400, Ampang Gadang, Kec. Ampak Angkek, Kab Agam, Sumatera Barat 26132`,
                coordinates: [-0.29435238261347196, 100.4021261842028]
            },
            {
                name: "EIGHTEEN CAR GARAGE",
                address: `Jl. Penjaringan No 40A, RT 03 RW 02, Penjaringan Sari, Kec. Rungkut, Kota Surabaya 60297`,
                coordinates: [-7.318034490351882, 112.78347582731595]
            }, {
                name: "CREATIVE AUTOMODIFIED",
                address: `JL. PEMUDA NO 56, TAMPAN, KEC PAYUNG SEKAKI, KOTA PEKANBARU, RIAU 28144`,
                coordinates: [0.5411526258944181, 101.41267441536378]
            }, {
                name: "BENGKEL AUTOPILOT",
                address: `Jl. Padang Bulan Selayang II, Kec Medan Selayang, Kota Medan, Sumatera Utara 20131`,
                coordinates: [3.5518029740906556, 98.63727563160383]
            }, {
                name: "AB UNDERSTEEL",
                address: `jl Sungai Walanae 27.Maricaya baru Makassar sulsel. 90142. ( belakang Hotel ISTANA)`,
                coordinates: [-5.147807650101609, 119.42395171427266]
            }, {
                name: "RAIN AUTOPARTS",
                address: `Jl. Super Raya No 164, Dero, Condongcatur, Kec. Depok, Kab. Sleman, Daerah Istimewa Yogyakarta 55281`,
                coordinates: [-7.751259760951398, 110.40963715427381]
            }, {
                name: "PING WHEELS",
                address: `Jl. Pesona Kalisari No 115, RW 01, Kalisari, Pasar Rebo, East Jakarta City, Jakarta 13790`,
                coordinates: [-6.3356850479453035, 106.85796956778333]
            }, {
                name: "FI AUDIO",
                address: `Jl. Guntur No 80, RT 01 RW 01, Guntur, Kec. Setia Budi, Kota Jakarta Selatan, DKI Jakarta 12989`,
                coordinates: [-6.2104368990551535, 106.83515371454845]
            }, {
                name: "AKASIA MOTOR",
                address: `Jl. Dr. Ratna No.39, RT.001/RW.001, Jatibening, Pondok Gede, Bekasi City, West Java 17412`,
                coordinates: [-6.268200893260522, 106.9497011987417]
            }, {
                name: "AESTHETIC GARAGE",
                address: `Jl Hang lekir No 14A, RT 09/RW 06, Gunung, Kec Kebayoran Baru, Kota Jakarta Selatan, DKI Jakarta 12120`,
                coordinates: [-6.230351177685353, 106.79553911429159]
            }
        ]

        locations.forEach((location) => {
            let marker = L.marker([location.coordinates[0], location.coordinates[1]], {
                icon: redIcon
            }).addTo(map).bindPopup(
                `<b>${location.name}</b><br>${location.address}`)
        })

        /* -------------------------------------------------------------------------- */
        /*                         Popup Promo Script Section                         */
        /* -------------------------------------------------------------------------- */

        /* ------------------------ Global Popup Promo Script ----------------------- */
        const closePromo = (element) => {
            element.classList.add('close');
            setTimeout(() => element.classList.add('hidden'), 200);
        }

        /* ------------------------ Popup Promo Close Script ------------------------ */
        const popupCloseBtns = document.querySelectorAll('[data-id="promo-close-btn"]');
        if (popupCloseBtns) {
            popupCloseBtns.forEach(btn => {
                btn.onclick = () => {
                    closePromo(btn.closest('.popup-promo-container'));
                }
            });
        }

        /* ---------------------- Popup Promo Countdown Script ---------------------- */
        // window.addEventListener('load', () => {
        //     const countdownSpan = document.querySelector('[data-id="promo-countdown"]');
        //     let countdown = parseInt(countdownSpan.textContent);
        //     let interval;
        //     const updateTimer = () => {
        //         countdown--;
        //         countdownSpan.textContent = countdown;
        //         if (countdown == 0) {
        //             clearInterval(interval);
        //             closePromo(countdownSpan.closest('.popup-promo-container'));
        //         }
        //     }
        //     interval = setInterval(updateTimer, 1000)
        // })
    </script>
</body>

</html>
