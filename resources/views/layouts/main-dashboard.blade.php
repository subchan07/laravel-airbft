<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>“AirRide”Smart lowered airsuspension brand_AIRBFTsuspension</title>

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('dashboard-page/plugins/izitoast/css/iziToast.min.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('dashboard-page/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('dashboard-page/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dashboard-page/dist/css/adminlte.min.css') }}">
    @stack('css')
    @vite('resources/css/app.css')
</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">

        <!-- Topbar -->
        @include('partials.dashboard.topbar')

        <!-- Main Sidebar Container -->
        @include('partials.dashboard.sidebar')

        <!-- Content Wrapper. Contains page content -->
        @yield('container-content')
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <script>
        const prefixUrl = "/admin";
    </script>

    <!-- jQuery -->
    <script src="{{ asset('dashboard-page/plugins/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('dashboard-page/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('dashboard-page/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dashboard-page/dist/js/adminlte.js') }}"></script>

    <script src="{{ asset('dashboard-page/plugins/izitoast/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('dashboard-page/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dashboard-page/dist/js/demo.js') }}"></script>

    <script src="{{ asset('dashboard-page/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <div class="modal fade" id="modalAddArticle">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Article</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('article.store') }}" method="POST" id="formNewArticle"
                    onsubmit="formNewArticle(event, this)">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title_article">Title</label>
                            <input type="text" name="title_article" id="title_article" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    @stack('script')
</body>

</html>
