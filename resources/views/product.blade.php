<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">

    <!-- Animation CSS -->
    <link rel="stylesheet" href="{{ asset('assets/new/css/animate.css') }}" type="text/css" />
    <!-- Font Css -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/new/font-awesome/4.7.0/css/font-awesome.min.css') }}" type="text/css"
        rel="stylesheet" />
    <link href="{{ asset('assets/new/css/ionicons.min.css') }}" type="text/css" rel="stylesheet" />
    <!-- Owl Css -->
    <link href="{{ asset('assets/new/css/owl.carousel.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('assets/new/css/owl.theme.default.min.css') }}" type="text/css" rel="stylesheet" />
    <!-- Magnific Popup Css -->
    <link href="{{ asset('assets/new/css/magnific-popup.css') }}" type="text/css" rel="stylesheet" />
    <!-- Bootstrap Css -->
    <!-- <link href="{{ asset('assets/new/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet" /> -->

    <!-- Price Filter Css -->
    <link href="{{ asset('assets/new/css/jquery-ui.css') }}" type="text/css" rel="stylesheet" />
    <!-- Scrollbar Css -->
    <link href="{{ asset('assets/new/css/mCustomScrollbar.min.css') }}" type="text/css" rel="stylesheet" />
    <!-- Select2 Css -->
    <link href="{{ asset('assets/new/css/select2.min.css') }}" type="text/css" rel="stylesheet" />
    <!-- main css -->
    <link href="{{ asset('assets/new/css/style.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('assets/new/css/responsive.css') }}" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/style1.css') }}" />
    <title>“AirRide”Smart lowered airsuspension brand_AIRBFTsuspension</title>

</head>

<body>
    <!-- ======= Header ======= -->
    @include('partials.landing-page.navbar')
    <!-- End Header -->

    <section class="breadcrumbs d-flex align-items-center product-bg">
    </section>
    <!-- End Header Section -->

    <!-- Start Shop Section -->
    <section class="shop-inner-section pt_large pb_large">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-8 col-md-12">
                    <form action="">
                        <div class="shop-options d-sm-flex justify-content-between align-items-center">
                            <input type="search" name="search" value="{{ request('search') }}"
                                placeholder="Search...."
                                style="  padding: 8px;
                        border: 1px solid #ccc;
                        border-radius: 6px;
                        width: 250px;">
                            <div class="sorting-option">
                                Urutkan
                                <select class="sorting-items" name="sort" onchange="this.form.submit()"
                                    style="background-color: white; border-radius:6px">
                                    <option value="abjad" @selected(request('sort') === 'abjad')>Alphabetical</option>
                                    <option value="price" @selected(request('sort') === 'price')>Harga: rendah ke tinggi</option>
                                    <option value="price-desc" @selected(request('sort') === 'price-desc')>Harga: tinggi ke rendah
                                    </option>
                                </select>
                            </div>
                            {{-- <div class="showing-items">
                            <p>Showing 1-9 of {{ $products->count() }} results</p>
                        </div> --}}
                            <div class="shop-list_grid">
                                <div class="list_grid-btns">
                                    <a href="javascript:void(0)" class="list-view"><i class="ion-navicon-round"></i></a>
                                    <a href="javascript:void(0)" class="grid-view on"><i class="ion-grid"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row list_grid_container grid">

                        @if ($products->count())
                            @foreach ($products as $key => $product)
                                <div class="col-md-4 col-6">
                                    <div class="product-box common-cart-box box-{{ $key }}">
                                        <div class="product-img common-cart-img">
                                            <img src="{{ $product->productImages->count() !== 0 ? asset('uploads/' . $product->productImages[0]->image) : 'https://placehold.co/400x300?text=No Pict' }}"
                                                alt="product-img" />
                                            <div class="hover-option">
                                            </div>
                                        </div>
                                        <div class="product-info common-cart-info text-center">
                                            <a href="{{ route('product.detail', ['product' => $product->slug]) }}"
                                                class="cart-name">{{ $product->name }}</a>
                                            <p class="cart-price">
                                                @if ($product->discount != 0)
                                                    <del>{{ format_rupiah($product->price, true) }}</del>
                                                    {{ format_rupiah($product->price - $product->price * ($product->discount / 100), true) }}
                                                @else
                                                    {{ format_rupiah($product->price, true) }}
                                                @endif
                                            </p>
                                            <p class="product-list-text">
                                                {!! $product->excerpt !!}
                                            </p>
                                            <div class="hover-option">
                                                <div class="add-cart-btn">
                                                    <a href="javascript:;" class="btn btn-primary">Add To Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <h4 class="text-center">No product found.</h4>
                            </div>
                        @endif

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <nav>
                                {{-- <ul class="pagination justify-content-center">
                                    <li class="active"><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li>
                                        <a href="#" aria-label="Next"><i class="fa fa-angle-right"></i></a>
                                    </li>
                                </ul> --}}
                                {{ $products->links() }}
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-12 order-lg-first">
                    <div class="shop-sidebar">
                        <div class="side-quantity-box side-box">
                            <div class="side-box-title">
                                <h6>Categories</h6>
                            </div>
                            <div class="quantity-box-detail">
                                <ul>
                                    @foreach ($categoryProducts as $category)
                                        <li>
                                            <a
                                                href="?category={{ $category->slug }}">{{ $category->name }}<span>({{ $category->product->count() }})</span></a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Section -->

    <!-- ======= Footer ======= -->
    @include('partials.landing-page.footer')
    <!-- End Footer -->

    <!-- Home Popup Section -->
    <div class="modal fade bd-example-modal-lg main-popup" id="exampleModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="newsletter-pop-up d-flex">
                        <div class="popup-img">
                            <img src="https://placehold.co/340x442" alt="popup-img" />
                        </div>
                        <div class="popup-form text-center">
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="ion-close-round"></i></span>
                            </button>
                            <div class="popup-logo">
                                <img src="{{ asset('assets/new/image/logo.png') }}" alt="logo" />
                            </div>
                            <div class="popup-text">
                                <p>Join us Now</p>
                                <h6>And get hot news about the theme</h6>
                            </div>
                            <form class="subscribe-popup-form" method="post" action="#">
                                <input name="email" required type="email" placeholder="Enter Your Email" />
                                <button class="btn btn-primary" title="Subscribe" type="submit">
                                    Subscribe
                                </button>
                            </form>
                            <div class="form-check">
                                <label>Don't show this popup again!
                                    <input class="defult-check" type="checkbox" checked="checked" />
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Screen Load Popup Section -->

    <!-- Start Quickview Popup Section -->
    <div id="test-popup3" class="white-popup quickview-popup mfp-hide">
        <div class="row">
            <div class="col-md-5">
                <div class="product-image">
                    <img class="product_img" src="https://placehold.co/400x430"
                        data-zoom-image="https://placehold.co/400x430" />
                </div>
                <div id="product_gallery" class="product_gallery_item owl-thumbs-slider owl-carousel owl-theme">
                    <div class="item">
                        <a href="#" class="active" data-image="https://placehold.co/400x430"
                            data-zoom-image="https://placehold.co/400x430">
                            <img src="https://placehold.co/400x430" />
                        </a>
                    </div>
                    <div class="item">
                        <a href="#" data-image="https://placehold.co/400x430"
                            data-zoom-image="https://placehold.co/400x430">
                            <img src="https://placehold.co/400x430" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="quickview-product-detail">
                    <h2 class="box-title">Ornare sed consequat</h2>
                    <h3 class="box-price"><del>$ 95.00</del>$ 81.00</h3>
                    <p class="box-text">
                        There are many variations of passages of Lorem Ipsum available,
                        but the majority have suffered alteration in some form, by
                        injected humour, or randomised words which don't look even
                        slightly believable.
                    </p>
                    <p class="stock">Availability: <span>In Stock</span></p>
                    <div class="quantity-box">
                        <p>Quantity:</p>
                        <div class="input-group">
                            <input type="button" value="-" class="minus" />
                            <input class="quantity-number qty" type="text" value="1" min="1"
                                max="10" />
                            <input type="button" value="+" class="plus" />
                        </div>
                        <div class="quickview-cart-btn">
                            <a href="#" class="btn btn-primary"><img
                                    src="{{ asset('assets/new/image/cart-icon-1.png') }}" alt="cart-icon-1" />
                                Add To Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Quickview Popup Section -->

    <a href="#" class="scrollup" style="display: none"><i class="ion-ios-arrow-up"></i></a>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Jquery js -->
    <script src="{{ asset('assets/new/js/jquery.min.js') }}" type="text/javascript"></script>
    <!-- Magnific Popup js -->
    <script src="{{ asset('assets/new/js/jquery.magnific-popup.min.js') }}" type="text/javascript"></script>
    <!-- Owl js -->
    <script src="{{ asset('assets/new/js/owl.carousel.min.js') }}" type="text/javascript"></script>
    <!-- Countdown js -->
    <script src="{{ asset('assets/new/js/countdown.min.js') }}" type="text/jscript"></script>
    <!-- Counter js -->
    <script src="{{ asset('assets/new/js/jquery.countup.js') }}" type="text/javascript"></script>
    <!-- waypoint js -->
    <script src="{{ asset('assets/new/js/waypoint.js') }}" type="text/javascript"></script>
    <!-- Select2 js -->
    <script src="{{ asset('assets/new/js/select2.min.js') }}" type="text/javascript"></script>
    <!-- Price Slider js -->
    <script src="{{ asset('assets/new/js/jquery-price-slider.js') }}" type="text/javascript"></script>
    <!-- jquery.elevatezoom js -->
    <script src="{{ asset('assets/new/js/jquery.elevatezoom.js') }}" type="text/javascript"></script>
    <!-- imagesloaded.pkgd.min js -->
    <script src="{{ asset('assets/new/js/imagesloaded.pkgd.min.js') }}" type="text/javascript"></script>
    <!-- isotope.min js -->
    <script src="{{ asset('assets/new/js/isotope.min.js') }}" type="text/javascript"></script>
    <!-- jquery.fitvids js -->
    <script src="{{ asset('assets/new/js/jquery.fitvids.js') }}" type="text/javascript"></script>
    <!-- mCustomScrollbar.concat.min js -->
    <script src="{{ asset('assets/new/js/mCustomScrollbar.concat.min.js') }}" type="text/javascript"></script>
    <!-- Custom css -->
    <script src="{{ asset('assets/new/js/custom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/main1.js') }}"></script>
</body>

</html>
