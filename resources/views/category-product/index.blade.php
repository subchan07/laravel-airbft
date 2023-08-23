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
                        <h1>Category Product</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Category Product</li>
                        </ol>
                    </div>
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

                            <div class="card-tools">
                                <a href="{{ route('category-product.create') }}" class="btn btn-sm btn-primary"><i
                                        class="fas fa-plus"></i> Category</a>
                                {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <p id="errorListProduct"></p>

                            <table id="tableProduct" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categoryProducts as $category)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td class="one-paragraph-datatable" title="{!! $category->description !!}">
                                                {!! $category->description !!}</td>
                                            </td>
                                            <td>
                                                @if (count($category->product) == 0)
                                                    <a href="javascript:;" class="btn btn-sm btn-danger"
                                                        id="btnDelete{{ $loop->iteration }}"
                                                        data-slug="{{ $category->slug }}" onclick="deleteProduct(this)"><i
                                                            class="fas fa-trash"></i></a>
                                                @else
                                                    <button class="btn btn-sm btn-danger disabled"><i
                                                            class="fas fa-trash"></i></button>
                                                @endif
                                                <a href="{{ route('category-product.edit', ['category' => $category->slug]) }}"
                                                    class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Default Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>One fine body&hellip;</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <script src="{{ asset('dashboard-page/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard-page/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard-page/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dashboard-page/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard-page/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dashboard-page/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            loadDataTable('#tableProduct')
        });

        function deleteProduct(input) {
            let parent1 = input.parentNode;
            let parent2 = parent1.parentNode;

            const slug = input.dataset.slug
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
                        url: `${prefixUrl}/category-product/${slug}`,
                        dataType: 'JSON',
                        beforeSend: function() {
                            showLoadingButton(`#${input.id}`)
                        },
                        success: function(response) {
                            resetDataTable('#tableProduct')
                            parent2.remove();
                            showFlashMessage(response.statusFlashMessage, response.textFlashMessage);
                            loadDataTable('#tableProduct')
                        },
                        error: function(xhr, status, error) {
                            $('#errorListProduct').html('')
                            hideLoadingButton(`#${input.id}`, '<i class="fas fa-trash"></i>')

                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                let errorsHtml = `<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>`
                                $.each(errors, function(key, value) {
                                    errorsHtml += '<li>' + value[0] + '</li>';
                                });
                                $('#errorListProduct').html(errorsHtml)
                            } else {
                                showFlashMessage(status, error);
                            }
                        }
                    })
                }
            })
        };
    </script>
@endpush
