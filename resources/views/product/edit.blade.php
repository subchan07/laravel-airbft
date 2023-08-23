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
                        <h1>Edit Product</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"><a href="{{ route('product.index') }}">Product</a></li>
                            <li class="breadcrumb-item active">Edit Product</li>
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
                            <p id="errorListFormUpdateProduct"></p>

                            <form id="formUpdateProduct"
                                action="{{ route('product.update', ['product' => $product->slug]) }}"
                                onsubmit="formUpdateProduct(event, this)">
                                @method('put')
                                <div class="form-group">
                                    <label for="category_product_id">Product Name</label>
                                    <select name="category_product_id" id="category_product_id" class="form-control"
                                        required>
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categoryProducts as $category)
                                            <option
                                                {{ $category->id == old('name', $product->category_product_id) ? 'selected' : '' }}
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Product Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name', $product->name) }}" autofocus autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <label for="price">Price</label>
                                            <input type="number" name="price" id="price" class="form-control"
                                                oninput="convertRupiahJs(this, '#showConvertPrice')"
                                                value="{{ old('price', $product->price) }}" required>
                                            <strong id="showConvertPrice"></strong>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="discount">Discount</label>
                                            <input type="number" name="discount" id="discount" class="form-control"
                                                min="0" max="100"
                                                value="{{ old('discount', $product->discount) }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="stock">Stock</label>
                                    <input type="number" name="stock" id="stock" class="form-control" min="0"
                                        value="{{ old('stock', $product->stock) }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="excerpt">Excerpt</label>
                                    <textarea name="excerpt" id="excerpt" rows="2" class="form-control" onkeydown="NoNewLine(event)" required>{{ old('excerpt', $product->excerpt) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" required>
                                    {{ old('description', $product->description) }}
                                      </textarea>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <a href="{{ route('product.index') }}" id="btnCancelFormUpdateProduct"
                                            class="btn btn-secondary"><i class="fa fa-chevron-left"></i> Back</a>
                                        <button type="submit" class="btn btn-success float-right">Edit</button>
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

        function formUpdateProduct(event, form) {
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
                    hideLoadingButton(`#${form.id} [type=submit]`, 'Edit')
                    showFlashMessage(response.statusFlashMessage, response.textFlashMessage);

                    const redirectUrl = $('#btnCancelFormUpdateProduct').prop('href')
                    location.href = redirectUrl
                    // window.location.replace(redirectUrl)
                },
                error: function(xhr, status, error) {
                    hideLoadingButton(`#${form.id} [type=submit]`, 'Edit')
                    const errors = xhr.responseJSON.errors;
                    let errorsHtml = `<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>`
                    $.each(errors, function(key, value) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    $('#errorListFormUpdateProduct').html(errorsHtml)
                }
            })
        };

        function NoNewLine(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        }
    </script>
@endpush
