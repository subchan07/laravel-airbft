@extends('layouts.main-dashboard')
@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('dashboard-page/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('dashboard-page/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-page//plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@section('container-content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $site }}</h1>
                    </div>
                    {{-- <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div> --}}
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">General</h3>
                            @if ($title == 'home')
                                <div class="card-tools">
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default">
                                        add
                                    </button>
                                </div>
                            @endif

                            @if ($title == 'portfolio')
                                <div class="card-tools">
                                    <a href="{{ route('main_page.create', ['mainPage' => $title]) }}"
                                        class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> New</a>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <p id="errorListProduct"></p>

                            <div class="table-responsive">
                                <table id="tableProduct" class="table table-sm table-hover table-striped">
                                    <thead>
                                        <tr>
                                            @if ($title == 'home')
                                                {{-- <th>Category</th> --}}
                                            @else
                                                <th>Content</th>
                                            @endif
                                            {{-- <th>Is Active</th> --}}
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mainPages as $main)
                                            <tr>
                                                @if ($title == 'home')
                                                    {{-- <td>{{ $main->category }}</td> --}}
                                                    @if (!is_array($main->content))
                                                        <td><img src="{{ asset('uploads/' . $main->content->image) }}"
                                                                alt="content image" style="width: 100%"></td>
                                                    @endif
                                                @else
                                                    <td class="one-paragraph-datatable" title='{!! $main->content == null ? '' : $main->content->description !!}'>
                                                        {!! $main->content == null ? '' : $main->content->description !!}</td>
                                                @endif
                                                {{-- <td>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customSwitch{{ $loop->iteration }}"
                                                            value="{{ $main->id }}"
                                                            {{ $main->is_active ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                            for="customSwitch{{ $loop->iteration }}"></label>
                                                    </div>
                                                </td> --}}
                                                {{-- <td>
                                                    <a href="{{ route('main_page.edit', ['mainPage' => $main->id]) }}"
                                                        class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                                    @if ($title == 'portfolio')
                                                        <a href="javascript:;" id="btnRemove{{ $loop->iteration }}"
                                                            onclick="deletePortfolio(this)" data-id="{{ $main->id }}"
                                                            class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                                    @endif
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    <tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@push('script')
    @if ($title == 'home')
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <a href="{{ route('main_page.create', ['mainPage' => 'shop', 'website' => $website->id]) }}"
                            class="btn btn-sm btn-default">Shop</a>
                        <a href="{{ route('main_page.create', ['mainPage' => 'article', 'website' => $website->id]) }}"
                            class="btn btn-sm btn-default">Article</a>
                        <a href="{{ route('main_page.create', ['mainPage' => 'call-us-now', 'website' => $website->id]) }}"
                            class="btn btn-sm btn-default">Call
                            Us Now</a>
                        <a href="{{ route('main_page.create', ['mainPage' => 'image', 'website' => $website->id]) }}"
                            class="btn btn-sm btn-default">Image</a>
                        <a href="{{ route('main_page.create', ['mainPage' => 'product-catalog', 'website' => $website->id]) }}"
                            class="btn btn-sm btn-default">Product Catalog</a>
                        <a href="{{ route('main_page.create', ['mainPage' => 'review', 'website' => $website->id]) }}"
                            class="btn btn-sm btn-default">Review</a>
                        <a href="{{ route('main_page.create', ['mainPage' => 'popup-promo', 'website' => $website->id]) }}"
                            class="btn btn-sm btn-default mt-1">Popup Promo</a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    @endif

    <script src="{{ asset('dashboard-page/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard-page/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard-page/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dashboard-page/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard-page/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dashboard-page/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            $('.custom-control-input').on('click', function() {
                const checkedVal = $(this).is(':checked')
                const valueEl = $(this).val()
                checkedVal == true ? $(this).attr('checked') : $(this).removeAttr('checked')

                $.ajax({
                    type: 'POST',
                    url: `${prefixUrl}/main-page/changeIsActive/${valueEl}`,
                    dataType: 'JSON',
                    data: {
                        _method: 'PUT',
                        is_active: checkedVal
                    },
                    beforeSend: function() {
                        $('.custom-control-input').attr('disabled', 'disabled')
                    },
                    success: function(response) {
                        $('.custom-control-input').removeAttr('disabled')
                        showFlashMessage(response.statusFlashMessage, response
                            .textFlashMessage);
                    },
                    error: function(xhr, status, error) {
                        $('.custom-control-input').removeAttr('disabled')
                        console.log(xhr);
                    }
                })
            })
        })
    </script>

    @if ($title == 'portfolio')
        <script>
            function deletePortfolio(input) {
                let parentRow = input.closest('tr');

                const id = input.dataset.id
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: `${prefixUrl}/main-page/${id}`,
                            dataType: 'JSON',
                            beforeSend: function() {
                                showLoadingButton(`#${input.id}`)
                            },
                            success: function(response) {
                                hideLoadingButton(`#${input.id}`,
                                    '<i class="fas fa-trash"></i>')
                                resetDataTable('#tableProduct')
                                parentRow.remove();
                                showFlashMessage(response.statusFlashMessage, response.textFlashMessage);
                                loadDataTable('#tableProduct')
                            },
                            error: function(xhr, status, error) {
                                hideLoadingButton(`#${input.id}`,
                                    '<i class="fas fa-trash"></i>')
                            }
                        })
                    }
                })
            };
        </script>
    @endif
@endpush
