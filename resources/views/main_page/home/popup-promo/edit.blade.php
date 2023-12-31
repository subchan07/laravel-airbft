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

                            <form method="POST"
                                id="formNew"action="{{ route('main_page.update', ['mainPage' => $mainPage->id]) }}"
                                onsubmit="formUpdate(event, this)" enctype="multipart/form-data">
                                @method('put')
                                <input type="hidden" name="category" value="{{ $mainPage }}">
                                <div class="form-group">
                                    <label for="upload_image">Upload Image</label>
                                    {{-- <img class="mb-2 col-sm-3" src="{{ asset('uploads/' . $mainPage->content->image) }}"
                                        id="previewImgDesktop"> --}}
                                    <input type="file" name="upload_image" id="upload_image" class=" form-control"
                                        onchange="previewImage(this,'#previewImgDesktop','#formNew', '.error-image')">
                                    <small class="text-danger error-image"></small>
                                </div>
                                <div class="form-group">
                                    <label for="product">Products</label>
                                    <select name="product" id="product" class="select2" style="width: 100%;" required>
                                        @foreach ($products as $product)
                                            <option @selected($product->id == $mainPage->content->product_id) value="{{ $product->id }}">
                                                {{ $product->name }}</option>
                                        @endforeach
                                        <option value="0">Maintenance</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="time" class="d-block">Popup Countdown Time (Second Interval)</label>
                                    <input type="date" value="{{ isset($mainPage->content->date) ? $mainPage->content->date : date('Y-m-d') }}" name="date" id="date">
                                    <input type="time" value="{{ isset($mainPage->content->time) ? $mainPage->content->time : '00:00' }}" name="time" id="time">
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <a href="{{ route('main_page', ['mainPage' => 'home', 'website' => $mainPage->website->slug]) }}"
                                            id="btnBackForm" class="btn btn-secondary"><i class="fa fa-chevron-left"></i>
                                            Back</a>
                                        <button type="submit" class="btn btn-success float-right">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <img src="{{ $mainPage->content->image ? asset('uploads/'.$mainPage->content->image) : "" }}" alt="" id="previewImgDesktop" style="width:100%; height:auto">
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
                    hideLoadingButton(`#${form.id} [type=submit]`, 'Create')
                    showFlashMessage(response.statusFlashMessage, response.textFlashMessage);

                    $('#errorListForm').html('')
                    const redirectUrl = $('#btnBackForm').prop('href')
                    location.href = redirectUrl
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseJSON);
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
