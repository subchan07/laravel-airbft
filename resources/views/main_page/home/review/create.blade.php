@extends('layouts.main-dashboard')

@section('container-content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="mb-2 row">
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

                            <form method="POST" id="formNew" action="{{ route('main_page.store', $website->id) }}"
                                onsubmit="formUpdate(event, this)" enctype="multipart/form-data">
                                <input type="hidden" name="category" value="{{ $mainPage }}">
                                <div class="form-group">
                                    <label for="upload_image">Upload Image</label>
                                    <img class="mb-2 col-sm-3" id="previewImgDesktop1">
                                    <input type="file" name="upload_image[]" id="upload_image" class="form-control"
                                        onchange="previewImage(this,'#previewImgDesktop1','#formNew', '.error-image1')"
                                        required>
                                    <small class="text-danger error-image1"></small>
                                </div>
                                <div class="form-group">
                                    <label for="upload_image">Upload Image</label>
                                    <img class="mb-2 col-sm-3" id="previewImgDesktop2">
                                    <input type="file" name="upload_image[]" id="upload_image" class="form-control"
                                        onchange="previewImage(this,'#previewImgDesktop2','#formNew', '.error-image2')"
                                        required>
                                    <small class="text-danger error-image2"></small>
                                </div>
                                <div class="form-group">
                                    <label for="upload_image">Upload Image</label>
                                    <img class="mb-2 col-sm-3" id="previewImgDesktop3">
                                    <input type="file" name="upload_image[]" id="upload_image" class="form-control"
                                        onchange="previewImage(this,'#previewImgDesktop3','#formNew', '.error-image3')"
                                        required>
                                    <small class="text-danger error-image3"></small>
                                </div>
                                <div class="form-group">
                                    <label for="upload_image">Upload Image</label>
                                    <img class="mb-2 col-sm-3" id="previewImgDesktop4">
                                    <input type="file" name="upload_image[]" id="upload_image" class="form-control"
                                        onchange="previewImage(this,'#previewImgDesktop4','#formNew', '.error-image4')"
                                        required>
                                    <small class="text-danger error-image4"></small>
                                </div>
                                <div class="form-group">
                                    <label for="upload_image">Upload Image</label>
                                    <img class="mb-2 col-sm-3" id="previewImgDesktop5">
                                    <input type="file" name="upload_image[]" id="upload_image" class="form-control"
                                        onchange="previewImage(this,'#previewImgDesktop5','#formNew', '.error-image5')"
                                        required>
                                    <small class="text-danger error-image5"></small>
                                </div>
                                <div class="form-group">
                                    <label for="upload_image">Upload Image</label>
                                    <img class="mb-2 col-sm-3" id="previewImgDesktop6">
                                    <input type="file" name="upload_image[]" id="upload_image" class="form-control"
                                        onchange="previewImage(this,'#previewImgDesktop6','#formNew', '.error-image6')"
                                        required>
                                    <small class="text-danger error-image6"></small>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <a href="{{ route('main_page', ['mainPage' => 'home', 'website' => $website->id]) }}"
                                            id="btnBackForm" class="btn btn-secondary"><i class="fa fa-chevron-left"></i>
                                            Back</a>
                                        <button type="submit" class="float-right btn btn-success">Create</button>
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
                <div class="p-0 modal-body">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <script>
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
                    hideLoadingButton(`#${form.id} [type=submit]`, 'Create')
                    showFlashMessage(response.statusFlashMessage, response.textFlashMessage);

                    $('#errorListForm').html('')
                    const redirectUrl = $('#btnBackForm').prop('href')
                    location.href = redirectUrl
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
