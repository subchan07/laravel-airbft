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
                        <h1>Article</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Article</li>
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
                        </div>
                        <div class="card-body">

                            <table id="tableArticle" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Title</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($articles as $article)
                                        <tr>
                                            <td width="1%">{{ $loop->iteration }}</td>
                                            <td width="1%">{{ $article->type }}</td>
                                            <td width="1%">{{ $article->status }}</td>
                                            <td class="one-paragraph-datatable" title="{{ $article->title }}">
                                                {{ $article->title }}</td>
                                            <td width="1%">

                                                <div class="btn-group dropleft float-right">
                                                    <button style=" border-radius: 0.25rem;" type="button"
                                                        class="btn btn-none btn-sm" data-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:;"
                                                                id="btnDelete{{ $loop->iteration }}"
                                                                data-slug="{{ $article->slug }}"
                                                                onclick="deleteArticle(this)"><i class="fas fa-trash text-danger"></i> Delete
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('article.edit', ['article' => $article->id]) }}"><i
                                                                    class="fas fa-edit text-warning"></i> Edit
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
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
            loadDataTable('#tableArticle')
        });

        function deleteArticle(input) {
            let parentRow = input.closest('tr');

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
                        url: `${prefixUrl}/article/${slug}`,
                        dataType: 'JSON',
                        beforeSend: function() {
                            showLoadingButton(`#${input.id}`)
                        },
                        success: function(response) {
                            hideLoadingButton(`#${input.id}`, '<i class="fas fa-trash text-danger"></i> Delete')
                            resetDataTable('#tableArticle')
                            parentRow.remove();
                            showFlashMessage(response.statusFlashMessage, response.textFlashMessage);
                            loadDataTable('#tableArticle')
                        },
                        error: function(xhr, status, error) {
                            hideLoadingButton(`#${input.id}`, '<i class="fas fa-trash text-danger"></i> Delete')
                        }
                    })
                }
            })
        };
    </script>
@endpush
