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
                        <h1>New Product</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"><a href="{{ route('product.index') }}">Product</a></li>
                            <li class="breadcrumb-item active">New Product</li>
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
                            <p id="errorListFormNewProduct"></p>

                            <form id="formNewProduct" action="{{ route('product.store') }}"
                                onsubmit="formAddNewProduct(event, this)">
                                <div class="form-group">
                                    <label for="category_product_id">Product Category</label>
                                    <select name="category_product_id" id="category_product_id" class="form-control"
                                        required>
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categoryProducts as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Product Name</label>
                                    <input type="text" name="name" id="name" class="form-control" autofocus
                                        autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <label for="price">Price</label>
                                            <input type="number" name="price" id="price" class="form-control"
                                                oninput="convertRupiahJs(this, '#showConvertPrice')" required>
                                            <strong id="showConvertPrice"></strong>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="discount">Discount</label>
                                            <input type="number" name="discount" id="discount" class="form-control"
                                                min="0" max="100" value="0" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="stock">Stock</label>
                                    <input type="number" name="stock" id="stock" class="form-control" min="0"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="excerpt">Excerpt</label>
                                    <textarea name="excerpt" id="excerpt" rows="2" class="form-control" onkeydown="NoNewLine(event)" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" required>
                                        Place some <u>text</u> <b>here</b>
                                      </textarea>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <a href="{{ route('product.index') }}" class="btn btn-secondary"><i
                                                class="fas fa-chevron-left"></i> Back</a>
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
                    ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['paragraph']],
                    ['height', ['height']],
                    ['insert', ['link']],
                    ['view', ['fullscreen']]
                ],
                styleTags: ['p', 'blockquote', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6']
            });
        });

        function formAddNewProduct(event, form) {
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
                    hideLoadingButton(`#${form.id} [type=submit]`, 'Create')
                    showFlashMessage(response.statusFlashMessage, response.textFlashMessage);

                    $(`#${form.id} #category_product_id`).val('')
                    $(`#${form.id} #name`).focus().val('')
                    $(`#${form.id} #price`).val('')
                    $(`#${form.id} #showConvertPrice`).html('')
                    $(`#${form.id} #stock`).val('')
                    $(`#${form.id} #discount`).val(0)
                    $(`#${form.id} #excerpt`).val('')
                    $(`#${form.id} .note-editable`).html(
                        'Place some <u>text</u> <b>here</b>')
                    $('#errorListFormNewProduct').html('')
                },
                error: function(xhr, status, error) {
                    hideLoadingButton(`#${form.id} [type=submit]`, 'Create')
                    const errors = xhr.responseJSON.errors;
                    let errorsHtml = `<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>`
                    $.each(errors, function(key, value) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    $('#errorListFormNewProduct').html(errorsHtml)
                }
            })
        }; // End send ajax add new product

        function NoNewLine(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        }
    </script>
@endpush
