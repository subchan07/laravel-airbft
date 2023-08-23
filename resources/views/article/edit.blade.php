@extends('layouts.main-dashboard')
@push('css')
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('dashboard-page/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-page/plugins/dropzone/min/dropzone.min.css') }}">
    <style>
        .max-width-10 {
            max-width: 4.5rem;
        }

        textarea {
            resize: none;
            overflow: hidden;
        }

        .form-component {
            position: relative;
        }

        .form-component .btn-remove-component {
            position: absolute;
            top: 0;
            right: -2.3rem;
            margin: 0.2rem;
            background: #dc3545;
            border: 0;
            padding: 0.4rem 0.5rem;
            border-radius: 5px;
        }

        .tags-input {
            display: inline-block;
            position: relative;
            border: 1px solid #ccc;
            padding: 5px;
            width: 100%;
        }

        .tags-input ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .tags-input li {
            display: inline-block;
            background-color: #fff;
            color: #333;
            padding: 5px 10px;
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .tags-input input[type="text"] {
            border: none;
            outline: none;
            padding: 5px;
            font-size: 14px;
        }

        .tags-input input[type="text"]:focus {
            outline: none;
        }

        .tags-input .delete-button {
            background-color: transparent;
            border: none;
            color: #999;
            cursor: pointer;
            margin-left: 5px;
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
                        <h1>New Article</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"><a href="{{ route('article.index') }}">Article</a></li>
                            <li class="breadcrumb-item active" id="breadcrumb-title-article">New Article</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row justify-content-center">
                <div class="col-md-12">

                    <div class="row justify-content-center">
                        <div class="col-md-11 mb-1">
                            <div class="float-right btn-save-top">
                                <button class="btn btn-flat btn-outline-secondary btn-save-article" id="draft"
                                    disabled>Draft</button>
                                <button class="btn btn-flat btn-info btn-save-article" id="publish"
                                    disabled>Publish</button>
                            </div>
                        </div>
                        <div class="col-md-10 col-10" style="margin-bottom: 8rem;">
                            <div id="content-preview">
                                <div class="form-group">
                                    <textarea
                                        style="font-weight: 600;font-size: clamp(1.8rem, 1.8rem + ((1vw - 0.2rem) * 1.142), 2.592rem);line-height: 1.1;"
                                        rows="1" class="form-control form-control-border bg-transparent" id="title_article" placeholder="Add title"
                                        oninput="auto_grow(this)"></textarea>
                                </div>

                                <div class="form-group">
                                    <div class="tags-input">
                                        <ul id="tags"></ul>
                                        <input type="text" id="input-tag" class="form-control"
                                            placeholder="Enter tag name" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <select id="type_article" class="form-control form-control-border"
                                                onchange="showOtherInput(this, '#otherTypeArticle', true)">
                                                <option value="">-- Select Type --</option>
                                                <option value="NEWS">NEWS</option>
                                                <option value="FAQ">FAQ</option>
                                                <option value="PARTY">PARTY</option>
                                                <option value="INSTALLATION">INSTALLATION</option>
                                                <option value="newTypeArticle">Other...</option>
                                            </select>
                                        </div>

                                        <div class="col-6">
                                            <input style="display: none" type="text" id="otherTypeArticle"
                                                class="form-control form-control-border" placeholder="input other type...">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Example single danger button -->
                            <div class="sampul-loader-custome d-none" id="loaderAddElement">
                                <div class="loader-custome"></div>
                            </div>
                            <div class="btn-group dropleft mt-3 float-right">
                                <button style=" border-radius: 0.25rem;" type="button" class="btn btn-dark btn-sm"
                                    data-toggle="dropdown">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    {{-- <li><a class="dropdown-item" href="javascript:;" onclick="addParagraph()">paragraph</a></li> --}}
                                    <li><a class="dropdown-item" href="javascript:;" onclick="addTextEditor()">text
                                            editor</a></li>
                                    <li><a class="dropdown-item" href="javascript:;" onclick="addImage()">picture</a></li>
                                    <li><a class="dropdown-item" href="javascript:;" onclick="addManyImage()">many
                                            pictures</a></li>
                                </ul>
                            </div>
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
    <script src="{{ asset('dashboard-page/plugins/dropzone/min/dropzone.min.js') }}"></script>

    <script>
        const arrayArticleField = [],
            tagArray = [];
        let idParagraph = 1,
            idTextEditor = 1;

        $(function() {

            $.ajax({
                type: "GET",
                url: `${prefixUrl}/article/data-json?condition=id&id={{ $article->id }}`,
                dataType: 'JSON',
                beforeSend: function() {
                    showHideLoader('show')
                },
                success: function(response) {
                    showHideLoader('hide')
                    coverImageArticle(response)
                    $('#title_article').val(response.title)
                    $('#breadcrumb-title-article').html(`current page (${response.status})`)
                    $('#type_article').val(response.type)


                    if (response.tags) {
                        for (var i = 0; i < response.tags.length; i++) {
                            pushTagtoArray(response.tags[i])
                        }
                    }

                    for (let i = 0; i < response.article_content.length; i++) {
                        if (response.article_content[i].type === 'picture') {
                            contentAddImage(response.article_content[i])
                        } else if (response.article_content[i].type === 'many-pictures') {
                            contentAddManyImage(response.article_content[i]);
                        } else if (response.article_content[i].type === 'paragraph') {
                            contentParagraph(response.article_content[i])
                        } else if (response.article_content[i].type === 'description') {
                            contentTextEditor(response.article_content[i])
                        }
                    }

                    $('.btn-save-article').removeAttr('disabled')

                    // console.log(response.tags)
                }
            });

            $('.btn-save-top').on('click', '.btn-save-article', function(event) {
                const idBtnSave = $(this).attr('id')
                const textBtnSave = $(this).html()

                const titleArticle = $('#title_article').val()
                const typeArticleVal = $('#type_article').val()
                const typeArticle = (typeArticleVal === 'newTypeArticle') ? $('#otherTypeArticle').val() :
                    typeArticleVal

                const arrayDataArticle = [{
                    title: titleArticle,
                    type: typeArticle,
                    status: idBtnSave,
                    tags: tagArray
                }]

                const arrayDataAticleContent = []
                $('.form-component .field-component').each(function() {
                    const valueArticleContent = $(this).val()
                    const idArticleContent = $(this).parent().parent().attr('id').replace('field',
                        '')

                    arrayDataAticleContent.push({
                        id: idArticleContent,
                        value: valueArticleContent
                    });
                });

                if (titleArticle === '') {
                    $('#title_article').focus()
                    showFlashMessage('error', '<strong>Error</strong>, Title is required!')
                } else if (typeArticle === '') {
                    showFlashMessage('error', '<strong>Error</strong>, Type is required!')
                } else {
                    $.ajax({
                        type: "POST",
                        url: `{{ route('article.update', ['article' => $article->id]) }}`,
                        dataType: 'JSON',
                        data: {
                            _method: "PUT",
                            article: arrayDataArticle,
                            articleContent: arrayDataAticleContent
                        },
                        beforeSend: function() {
                            showLoadingButton(`.btn-save-article#${idBtnSave}`)
                        },
                        success: function(response) {
                            hideLoadingButton(`.btn-save-article#${idBtnSave}`, textBtnSave)
                            showFlashMessage(response.statusFlashMessage, response
                                .textFlashMessage);
                            location.href = '{{ route('article.index') }}'

                        },
                        error: function(xhr, statusError, error) {
                            hideLoadingButton(`.btn-save-article#${idBtnSave}`, textBtnSave)
                        }
                    })
                }
            })

            $('#content-preview').on('click', '.btn-remove-component', function(event) {
                const parentEvent = $(this).parent();
                const idArticleContent = parentEvent.attr('id').replace('field', '');

                const textarea = parentEvent.find('textarea.field-component')
                const textarea1 = parentEvent.find('.paragraphField')

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
                            url: `${prefixUrl}/article/delete-conponent-article-content/${idArticleContent}`,
                            dataType: 'JSON',
                            success: function(response) {
                                // console.log(response);
                                parentEvent.remove()
                                showFlashMessage(response.statusFlashMessage, response
                                    .textFlashMessage);
                            },
                            error: function(xhr, status, error) {
                                showFlashMessage('error',
                                    '<strong>Error,</strong> data gagal dihapus!')
                            }
                        })
                    }
                })

            });
        });

        function addParagraph() {
            $.ajax({
                type: "POST",
                url: `{{ route('articleContent.store') }}`,
                dataType: 'JSON',
                data: {
                    type: 'paragraph',
                    article_id: '{{ $article->id }}'
                },
                beforeSend: function() {
                    showHideLoader('show')
                },
                success: function(response) {
                    showHideLoader('hide')
                    contentParagraph(response)
                },
                error: function(xhr, status, error) {
                    showHideLoader('hide')
                }
            })
        }

        function contentParagraph(response) {
            $('#content-preview').append(`<div class="form-component" id="field${response.id}">
                                            <button class="btn-remove-component fa fa-trash"></button>
                                            <div class="form-group">
                                                <textarea name="paragraph" class="field-component form-control form-control-border bg-transparent" rows="1"
                                                    placeholder="Add parapgraph" oninput="auto_grow(this)">${response.content ? response.content : ''}</textarea>
                                            </div>
                                        </div>`)
        }

        function addTextEditor() {
            $.ajax({
                type: "POST",
                url: `{{ route('articleContent.store') }}`,
                dataType: 'JSON',
                data: {
                    type: 'description',
                    article_id: '{{ $article->id }}'
                },
                beforeSend: function() {
                    showHideLoader('show')
                },
                success: function(response) {
                    showHideLoader('hide')
                    contentTextEditor(response)
                },
                error: function(xhr, status, error) {
                    showHideLoader('hide')
                }
            })
        }

        function contentTextEditor(response) {
            $('#content-preview').append(`<div class="form-component mt-4" id="field${response.id}">
                                            <button class="btn-remove-component fa fa-trash"></button><div class="form-group">
                                            <textarea name="description" class="field-component form-control" required>${response.content ?? "Place some <u>text</u> <b>here</b>"}</textarea>
                                            </div>
                                        </div>`)

            $(`#field${response.id}`).find('textarea').summernote({
                toolbar: [
                    // [groupName, [list of button]]
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
        }

        function addImage() {
            $.ajax({
                type: "POST",
                url: `{{ route('articleContent.store') }}`,
                dataType: 'JSON',
                data: {
                    type: 'picture',
                    article_id: '{{ $article->id }}'
                },
                beforeSend: function() {
                    showHideLoader('show')
                },
                success: function(response) {
                    showHideLoader('hide')
                    contentAddImage(response)

                },
                error: function(xhr, status, error) {
                    showHideLoader('hide')
                }
            })
        }

        function contentAddImage(response) {
            $("#content-preview").append(`<div class="form-component" id="field${response.id}">
                                            <button class="btn-remove-component fa fa-trash"></button>
                                            <form method="post" action="${prefixUrl}/article/article-content/${response.id}"
                                            enctype="multipart/form-data" class="dropzone mt-2" id="dropzoneImage${response.id}">
                                                {{ csrf_field() }}
                                                @method('put')
                                                <div class="dz-message py-6">
                                                    <figure class="max-width-10 mx-auto mb-3">
                                                        <img class="js-svg-injector"
                                                            src="https://htmlstream.com/preview/front-v2.7.0/assets/svg/illustrations/drag-n-drop.svg"
                                                            alt="Image Description" data-parent="#SVGIcon">
                                                    </figure>
                                                    <span class="d-block">Drag one file here to upload.</span>
                                                </div>
                                            </form>
                                        </div>`)

            // Option Dropzone
            let dropzoneInstance = new Dropzone(`#dropzoneImage${response.id}`, {
                maxFiles: 1,
                maxFilesize: 4,
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                addRemoveLinks: true,
                timeout: 50000,
                init: function() {
                    if (response.content) {
                        var myDropzone = this;

                        // Fetch the data that has already been uploaded.
                        $.get(`${prefixUrl}/article/article-image/${response.id}`, function(
                            data) {

                            let mockFile = {
                                name: data.name,
                                size: data.size,
                                status: 'success'
                            };
                            let callback = null; // Optional callback when it's done
                            let crossOrigin =
                                null; // Added to the `img` tag for crossOrigin handling
                            let resizeThumbnail =
                                false; // Tells Dropzone whether it should resize the image first
                            myDropzone.displayExistingFile(mockFile,
                                data.path, callback, crossOrigin,
                                resizeThumbnail);
                            myDropzone.previewsContainer.lastElementChild.id = data.name
                        });
                    }
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
                            return Dropzone.confirm("Are You Sure to " + this.options
                                .dictRemoveFile,
                                function() {
                                    $.ajax({
                                        type: 'DELETE',
                                        url: `${prefixUrl}/article/article-content/${response.id}`,
                                        data: {
                                            filename: name,
                                        },
                                        success: function(data) {
                                            alert(data.success +
                                                " File has been successfully removed!"
                                            );
                                        },
                                        error: function(e) {
                                            console.log(e);
                                        }
                                    });
                                    return (fileRef = file.previewElement) != null ?
                                        fileRef.parentNode.removeChild(file
                                            .previewElement) : void 0;
                                });
                        } else {
                            let fileRef;
                            return (fileRef = file.previewElement) != null ?
                                fileRef.parentNode.removeChild(file.previewElement) :
                                void 0;
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
                        message =
                        response; //dropzone sends it's own error messages in string
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
            })
        }

        function addManyImage() {
            $.ajax({
                type: "POST",
                url: `{{ route('articleContent.store') }}`,
                dataType: 'JSON',
                data: {
                    type: 'many-pictures',
                    article_id: '{{ $article->id }}'
                },
                beforeSend: function() {
                    showHideLoader('show')
                },
                success: function(response) {
                    showHideLoader('hide')
                    contentAddManyImage(response)
                },
                error: function(xhr, status, error) {
                    showHideLoader('hide')
                }
            })
        }

        function contentAddManyImage(response) {
            $("#content-preview").append(`<div class="form-component" id="field${response.id}">
                                            <button class="btn-remove-component fa fa-trash"></button>
                                            <form method="post" action="${prefixUrl}/article/article-content/${response.id}"
                                            enctype="multipart/form-data" class="dropzone mt-2" id="dropzoneManyImage${response.id}">
                                                {{ csrf_field() }}
                                                @method('put')
                                                <div class="dz-message py-6">
                                                    <figure class="max-width-10 mx-auto mb-3">
                                                        <img class="js-svg-injector"
                                                            src="https://htmlstream.com/preview/front-v2.7.0/assets/svg/illustrations/drag-n-drop.svg"
                                                            alt="Image Description" data-parent="#SVGIcon">
                                                    </figure>
                                                    <span class="d-block">Drag files here to upload</span>
                                                </div>
                                            </form>
                                        </div>`)

            // Option Dropzone
            let dropzoneInstance = new Dropzone(`#dropzoneManyImage${response.id}`, {
                maxFilesize: 4,
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                addRemoveLinks: true,
                timeout: 50000,
                init: function() {
                    if (response.content) {
                        var myDropzone = this;

                        // Fetch the data that has already been uploaded.
                        $.get(`${prefixUrl}/article/article-image/${response.id}`, function(data) {
                            for (var i = 0; i < data.length; i++) {

                                let mockFile = {
                                    name: data[i].name,
                                    size: data[i].size,
                                    status: 'success'
                                };
                                let callback = null; // Optional callback when it's done
                                let crossOrigin =
                                    null; // Added to the `img` tag for crossOrigin handling
                                let resizeThumbnail =
                                    false; // Tells Dropzone whether it should resize the image first
                                myDropzone.displayExistingFile(mockFile,
                                    data[i].path, callback, crossOrigin,
                                    resizeThumbnail);
                                myDropzone.previewsContainer.lastElementChild.id = data[
                                    i].name
                            }
                        });
                    }
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
                            return Dropzone.confirm("Are You Sure to " + this.options
                                .dictRemoveFile,
                                function() {
                                    $.ajax({
                                        type: 'DELETE',
                                        url: `${prefixUrl}/article/article-content/${response.id}`,
                                        data: {
                                            filename: name,
                                        },
                                        success: function(data) {
                                            alert(data.success +
                                                " File has been successfully removed!"
                                            );
                                        },
                                        error: function(e) {
                                            console.log(e);
                                        }
                                    });
                                    return (fileRef = file.previewElement) != null ?
                                        fileRef.parentNode.removeChild(file
                                            .previewElement) : void 0;
                                });
                        } else {
                            let fileRef;
                            return (fileRef = file.previewElement) != null ?
                                fileRef.parentNode.removeChild(file.previewElement) :
                                void 0;
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
                        message =
                        response; //dropzone sends it's own error messages in string
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
            })
        }

        // Input Tags
        // Get the tags and input elements from the DOM
        const tags = document.getElementById('tags');
        const input = document.getElementById('input-tag');

        // Add an event listener for keydown on the input element
        input.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();

                const tagContent = input.value.trim();

                if (tagContent !== '' && !tagArray.includes(tagContent)) {
                    pushTagtoArray(tagContent)
                }
            }
        });

        function pushTagtoArray(tagContent) {
            tagArray.push(tagContent);

            const tag = document.createElement('li');
            tag.innerHTML = `<span>${tagContent}</span>`;
            tag.innerHTML += '<button class="delete-button">X</button>';
            tags.appendChild(tag);

            input.value = '';
        }

        tags.addEventListener('click', function(event) {
            if (event.target.classList.contains('delete-button')) {
                const liElement = event.target.parentNode;
                const spanElement = liElement.querySelector('span');
                const spanText = spanElement.textContent;

                const tagToRemove = spanText.trim();
                const tagIndex = tagArray.indexOf(tagToRemove);

                if (tagIndex !== -1) {
                    tagArray.splice(tagIndex, 1);
                }

                liElement.remove();
            }
        });

        function showOtherInput(input, targetEl, validation = false) {
            let value = input.options[input.selectedIndex].value
            let elementTarget = document.querySelector(targetEl)
            let parentNote = input.parentNode

            if (value === 'newTypeArticle') {
                input.required = true
                elementTarget.style.display = 'block'
                elementTarget.required = true
                elementTarget.focus()

                if (validation === true) {
                    parentNote.classList.remove('col-12')
                    parentNote.classList.add('col-6')
                }
            } else {
                input.required = false
                elementTarget.style.display = 'none'
                elementTarget.required = false

                if (validation === true) {
                    parentNote.classList.remove('col-6')
                    parentNote.classList.add('col-12')
                }
            }
        }

        function showHideLoader(condition) {
            if (condition == 'show') {
                $('#loaderAddElement').removeClass('d-none')
            } else if (condition == 'hide') {
                $('#loaderAddElement').addClass('d-none')
            }
        }

        function coverImageArticle(response) {
            $('#content-preview').append(`<div class="form-group">
                                            <form method="post" action="${prefixUrl}/article/cover-article/upload/{{ $article->id }}"
                                                enctype="multipart/form-data" class="dropzone mt-2" id="uploadCoverImage">
                                                {{ csrf_field() }}
                                                <div class="dz-message py-6">
                                                    <figure class="max-width-10 mx-auto mb-3">
                                                        <img class="js-svg-injector"
                                                            src="https://htmlstream.com/preview/front-v2.7.0/assets/svg/illustrations/drag-n-drop.svg"
                                                            alt="Image Description" data-parent="#SVGIcon">
                                                    </figure>
                                                    <span class="d-block">Drag one file here to upload a cover image.</span>
                                                </div>
                                            </form>
                                        </div>`)

            let dropzoneInstance = new Dropzone(`#uploadCoverImage`, {
                maxFiles: 1,
                maxFilesize: 4,
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                addRemoveLinks: true,
                timeout: 50000,
                init: function() {
                    if (response.cover_image) {
                        var myDropzone = this;

                        // Fetch the data that has already been uploaded.
                        $.get(`${prefixUrl}/article/data-json?condition=cover-image&id=${response.id}`,
                            function(
                                data) {

                                let mockFile = {
                                    name: data.name,
                                    size: data.size,
                                    status: 'success'
                                };
                                let callback = null; // Optional callback when it's done
                                let crossOrigin =
                                    null; // Added to the `img` tag for crossOrigin handling
                                let resizeThumbnail =
                                    false; // Tells Dropzone whether it should resize the image first
                                myDropzone.displayExistingFile(mockFile,
                                    data.path, callback, crossOrigin,
                                    resizeThumbnail);
                                myDropzone.previewsContainer.lastElementChild.id = data.name
                            });
                    }
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
                            return Dropzone.confirm("Are You Sure to " + this.options
                                .dictRemoveFile,
                                function() {
                                    $.ajax({
                                        type: 'POST',
                                        url: `${prefixUrl}/article/cover-article/delete/${response.id}`,
                                        data: {
                                            filename: name,
                                        },
                                        success: function(data) {
                                            alert(data.success +
                                                " File has been successfully removed!"
                                            );
                                        },
                                        error: function(e) {
                                            console.log(e);
                                        }
                                    });
                                    return (fileRef = file.previewElement) != null ?
                                        fileRef.parentNode.removeChild(file
                                            .previewElement) : void 0;
                                });
                        } else {
                            let fileRef;
                            return (fileRef = file.previewElement) != null ?
                                fileRef.parentNode.removeChild(file.previewElement) :
                                void 0;
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
                        message =
                        response; //dropzone sends it's own error messages in string
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
            })
        }

        // // Menambahkan event listener untuk saat pengguna menekan tombol "Back" di browser
        // window.addEventListener('popstate', function(event) {
        //     // Memeriksa apakah pengguna benar-benar ingin kembali
        //     const confirmed = confirm('Apakah Anda yakin ingin meninggalkan halaman?');
        //     if (!confirmed) {
        //         // Menghentikan perubahan history jika pengguna tidak yakin
        //         history.pushState(null, null, event.state);
        //     }
        // });

        // // Menambahkan event listener untuk konfirmasi saat pengguna akan meninggalkan halaman
        // window.onbeforeunload = function(event) {
        //     return 'Apakah Anda yakin ingin meninggalkan halaman?';
        // };
    </script>
@endpush
