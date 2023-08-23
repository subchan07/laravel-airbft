@extends('layouts.main-dashboard')
@push('css')
    <!-- dropzonejs -->
    <link rel="stylesheet" href="{{ asset('dashboard-page/plugins/dropzone/min/dropzone.min.css') }}">
    <style>
        .max-width-10 {
            max-width: 4.5rem;
        }
    </style>
@endpush


@section('container-content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Product Image</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"><a href="{{ route('product.index') }}">Product</a></li>
                            <li class="breadcrumb-item active">Product Image</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            {{-- <div class="row">
            <div class="col-md-6"> --}}
            <div class="card card-secondary">
                <div class="card-body">
                    <form method="post" action="{{ route('productImage.store') }}" enctype="multipart/form-data"
                        class="dropzone" id="dropzone">
                        {{ csrf_field() }}
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <!-- Dropzone -->
                        <div class="dz-message py-6">
                            <figure class="max-width-10 mx-auto mb-3">
                                <img class="js-svg-injector"
                                    src="https://htmlstream.com/preview/front-v2.7.0/assets/svg/illustrations/drag-n-drop.svg"
                                    alt="Image Description" data-parent="#SVGIcon">
                            </figure>
                            <span class="d-block">Drag files here to upload</span>
                        </div>
                        <!-- End Dropzone -->
                    </form>
                    <a href="{{ route('product.index') }}" class="btn btn-sm btn-secondary mt-3">
                        <i class="fa fa-chevron-left"></i> Back
                    </a>
                </div>
            </div>
            <!-- /.card-body -->
            {{-- </div>
            <!-- /.card -->
        </div> --}}
        </section>
        <!-- /.content -->
    </div>
@endsection

@push('script')
    <!-- dropzonejs -->
    <script src="{{ asset('dashboard-page/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script>
        Dropzone.options.dropzone = {
            // maxFiles: 5,
            maxFilesize: 4,
            //~ renameFile: function(file) {
            //~ let dt = new Date();
            //~ let time = dt.getTime();
            //~ return time+"-"+file.name;    // to rename file name but i didn't use it. i renamed file with php in controller.
            //~ },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 50000,
            init: function() {
                var myDropzone = this;

                // Fetch the data that has already been uploaded.
                $.get(`${prefixUrl}/product/image/{{ $product->slug }}`, function(data) {
                    // Add the data to the Dropzone.
                        for (var i = 0; i < data.length; i++) {
                            // myDropzone.previewElement.id = data[i].name;

                            let mockFile = {
                                name: data[i].name,
                                size: data[i].size,
                                status: 'success'
                            };
                            let callback = null; // Optional callback when it's done
                            let crossOrigin = null; // Added to the `img` tag for crossOrigin handling
                            let resizeThumbnail =
                                false; // Tells Dropzone whether it should resize the image first
                            myDropzone.displayExistingFile(mockFile,
                                data[i].path, callback, crossOrigin,
                                resizeThumbnail);
                            myDropzone.previewsContainer.lastElementChild.id = data[i].name
                        }
                });
            },
            removedfile: function(file) {
                if (this.options.dictRemoveFile) {
                    let fileRef, name;
                    if (file.previewElement.id != "") {
                        name = file.previewElement.id;
                    } else {
                        name = file.name;
                    }
                    if (file.status === 'success') {
                        return Dropzone.confirm("Are You Sure to " + this.options.dictRemoveFile, function() {
                            $.ajax({
                                type: 'POST',
                                url: `${prefixUrl}/product/image/destroy`,
                                data: {
                                    filename: name
                                },
                                success: function(data) {
                                    alert(data.success +
                                        " File has been successfully removed!");
                                },
                                error: function(e) {
                                    console.log(e);
                                }
                            });
                            return (fileRef = file.previewElement) != null ?
                                fileRef.parentNode.removeChild(file.previewElement) : void 0;
                        });
                    } else {
                        let fileRef;
                        return (fileRef = file.previewElement) != null ?
                            fileRef.parentNode.removeChild(file.previewElement) : void 0;
                    }

                }
            },
            success: function(file, response) {
                file.previewElement.id = response.success;
                // set new images names in dropzone’s preview box.
                let olddatadzname = file.previewElement.querySelector("[data-dz-name]");
                file.previewElement.querySelector("img").alt = response.success;
                olddatadzname.innerHTML = response.success;
            },
            error: function(file, response) {
                let message
                if ($.type(response) === "string")
                    message = response; //dropzone sends it's own error messages in string
                else
                    message = response.message;
                file.previewElement.classList.add("dz-error");
                _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                _results = [];
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i];
                    _results.push(node.textContent = message);
                }
                return _results;
            }

        };
    </script>
@endpush
