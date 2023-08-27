@extends('layouts.main-dashboard')
@push('css')
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('dashboard-page/plugins/summernote/summernote-bs4.min.css') }}">
@endpush


@section('container-content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>New Category Product</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"><a href="{{ route('category-product.index') }}">Category
                                    Product</a></li>
                            <li class="breadcrumb-item active">New Category</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <p id="errorListFormNewCategory"></p>

                            <form id="formNewCategory" action="{{ route('category-product.store') }}" onsubmit="formAddNewCategory(event, this)"
                                enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="name">Category Name</label>
                                    <input type="text" name="name" id="name" class="form-control" autofocus autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="thumbnail">Thumbnail</label>
                                    <input type="file" name="thumbnail" id="thumbnail" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="hover_thumbnail">Hover Thumbnail</label>
                                    <input type="file" name="hover_thumbnail" id="hover_thumbnail" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" required>
                                      </textarea>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <a href="{{ route('category-product.index') }}" class="btn btn-secondary"><i class="fas fa-chevron-left"></i>
                                            Back</a>
                                        <button type="submit" class="btn btn-success float-right">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@push('script')
    <!-- Summernote -->
    <script src="{{ asset('dashboard-page/plugins/summernote/summernote-bs4.min.js') }}"></script>

    <script>
        $(function() {
            // Summernote
            $('#description').summernote({
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                ]
            });
        });

        function formAddNewCategory(event, form) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: form.action,
                dataType: 'JSON',
                data: new FormData(form),
                processData: false,
                contentType: false,
                beforeSend: function() {
                    showLoadingButton(`#${form.id} [type=submit]`)
                },
                success: function(response) {
                    $('#errorListFormNewCategory').html('')

                    hideLoadingButton(`#${form.id} [type=submit]`, 'Create')
                    showFlashMessage(response.statusFlashMessage, response.textFlashMessage);

                    $(`#${form.id} #name`).focus().val('')
                    $(`#${form.id} #thumbnail`).val('')
                    $(`#${form.id} .note-editable`).html(
                        'Place some <u>text</u> <b>here</b>')
                    $('#errorListFormNewCategory').html('')
                },
                error: function(xhr, status, error) {
                    $('#errorListFormNewCategory').html('')
                    hideLoadingButton(`#${form.id} [type=submit]`, 'Create')

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let errorsHtml = `<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>`
                        $.each(errors, function(key, value) {
                            errorsHtml += '<li>' + value[0] + '</li>';
                        });
                        $('#errorListFormNewCategory').html(errorsHtml)
                    } else {
                        showFlashMessage(status, error);
                    }
                }
            })
        }; // End send ajax add new product
    </script>
@endpush
