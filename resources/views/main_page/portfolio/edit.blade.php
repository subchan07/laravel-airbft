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
                        <h1>{{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('main_page', ['mainPage' => 'portfolio']) }}">Portfolio</a></li>
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
                            <p id="errorListFormUpdate"></p>

                            @php
                                $image = '';
                                $description = '';
                                if ($mainPage != null && $mainPage->content != null) {
                                    $image = $mainPage->content->image ?? '';
                                    $description = $main->content->description ?? '';
                                }
                            @endphp

                            <form id="formUpdateCategory"
                                action="{{ route('main_page.update', ['mainPage' => $mainPage->id]) }}"
                                onsubmit="formUpdateCategory(event, this)">
                                @method('put')
                                <input type="hidden" name="category" value="{{ $mainPage->sub_page }}">
                                <div class="form-group">
                                    <label for="thumbnail">Thumbnail</label>
                                    @if ($image)
                                        <button type="button" class="badge badge-dark modalImagePreview float-right"
                                            data-toggle="modal" data-target="#modal-image-preview"
                                            data-altimg="Thumbnail {{ $mainPage->name }}"
                                            data-srcimg="{{ asset('uploads/' . $mainPage->content->image) }}">Old
                                            image</button>
                                    @endif
                                    <input type="file" name="thumbnail" id="thumbnail" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" required>
                                    {{ old('description', $description) }}
                                      </textarea>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <a href="{{ route('main_page', ['mainPage' => 'portfolio']) }}"
                                            id="btnCancelFormUpdateCategory" class="btn btn-secondary"><i
                                                class="fa fa-chevron-left"></i> Back</a>
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

        $('.modalImagePreview').click(function() {
            const alt = $(this).data('altimg')
            const src = $(this).data('srcimg')
            const target = $(this).data('target')

            $(`${target} .modal-body`).html(`<img src="${src}" alt="${alt}" class="img-fluid" width="100%">`)
        });

        function formUpdateCategory(event, form) {
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

                    $('#errorListFormUpdate').html('')
                    const redirectUrl = $('#btnCancelFormUpdateCategory').prop('href')
                    location.href = redirectUrl
                },
                error: function(xhr, status, error) {
                    $('#errorListFormUpdate').html('')
                    hideLoadingButton(`#${form.id} [type=submit]`, 'Edit')

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let errorsHtml = `<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>`
                        $.each(errors, function(key, value) {
                            errorsHtml += '<li>' + value[0] + '</li>';
                        });
                        $('#errorListFormUpdate').html(errorsHtml)
                    } else {
                        showFlashMessage(status, error);
                    }
                }
            })
        };
    </script>
@endpush
