@extends('layouts.main-dashboard')
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('dashboard-page/plugins/select2/css/select2.min.css') }}">
@endpush

@section('container-content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Main Page</li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
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
                            <p id="errorListForm"></p>

                            <form id="formNew" action="{{ route('main_page.update', ['mainPage' => $mainPage->id]) }}"
                                onsubmit="formUpdate(event, this)" enctype="multipart/form-data">
                                @method('put')
                                <div class="form-group">
                                    <label for="upload_image">Upload Image</label>
                                    @if ($mainPage->content != null && $mainPage->content->image != null)
                                        <button type="button" class="badge badge-dark modalImagePreview float-right"
                                            data-toggle="modal" data-target="#modal-image-preview"
                                            data-altimg="{{ $mainPage->category }}"
                                            data-srcimg="{{ asset('uploads/' . $mainPage->content->image) }}">Old
                                            image</button>
                                    @endif
                                    <img class="mb-2 col-sm-3" id="previewImgDesktop">
                                    <input type="file" name="upload_image" id="upload_image" class="form-control"
                                        onchange="previewImage(this,'#previewImgDesktop','#formNew', '.error-image')">
                                    <small class="text-danger error-image"></small>
                                </div>
                                <div class="form-group">
                                    <label for="article">Article</label>
                                    <select name="article_id" id="article" class="form-control select2"
                                        style="width: 100%;">
                                        @foreach ($articles as $article)
                                            <option
                                                {{ $mainPage->content != null && $mainPage->content->article_id != null && $mainPage->content->article_id == $article->id ? 'selected' : '' }}
                                                value="{{ $article->id }}">{{ $article->title }}</option>
                                        @endforeach
                                        <option
                                            {{ $mainPage->content == null || $mainPage->content->article_id == 0 ? 'selected' : '' }}
                                            value="0">Maintenance</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <a href="{{ route('main_page', ['mainPage' => 'home', 'website' => $mainPage->website->slug]) }}"
                                            id="btnBackForm" class="btn btn-secondary"><i class="fa fa-chevron-left"></i>
                                            Back</a>
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
    <div class="modal fade" id="modal-image-preview">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-0">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <script src="{{ asset('dashboard-page/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        //Initialize Select2 Elements
        $('.select2').select2()

        function formUpdate(event, form) {
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

                    $('#errorListForm').html('')
                    const redirectUrl = $('#btnBackForm').prop('href')
                    location.href = redirectUrl
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
                    $('#errorListForm').html(errorsHtml)
                }
            })
        }

        $('.modalImagePreview').click(function() {
            const alt = $(this).data('altimg')
            const src = $(this).data('srcimg')
            const target = $(this).data('target')

            $(`${target} .modal-body`).html(`<img src="${src}" alt="${alt}" class="img-fluid" width="100%">`)
        })

        function previewImage(input, target, idform, errorImage) {
            const image = input
            const fileName = image.files[0].name
            const imgPreview = document.querySelector(target)
            const ekstensiValid = ['png', 'jpg', 'jpeg', 'gif']
            const fileExtension = fileName.split('.').pop().toLowerCase();
            const buttonSubmit = document.querySelector(`${idform} [type="button"]`)
            const errorImageText = document.querySelector(errorImage)

            // if (fileExtension.includes(ekstensiValid)) {
            imgPreview.style.display = 'block'
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0])

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result
            }
            // } else {
            // errorImageText.innerHTML = ''
            // }

        }
    </script>
@endpush
