@extends('layouts.main-dashboard')
@section('container-content')
    <main class="promotion content-wrapper">
        <section id="header" class="header">
            <h1>Promotin Page</h1>
            <button title="Instruction in Editing" class="instruction-open" data-toggle-component="instruction"
                data-target="#action-instruction"><i class="fas fa-question"></i></button>
        </section>
        <section class="promotion-contents">
            <div class="img-container">
                <img src="{{ asset('assets/img/promo-page/navbar.png') }}" alt="Promotion Header"
                    class="aspect-16/1 promotion-image">
                <div class="action-container">
                    <button class="edit-btn instruction-btn"><i class="fas fa-edit fa-xs"
                            style="color: #ffffff;"></i></button>
                    <button class="up-btn instruction-btn"><i class="fas fa-arrow-alt-circle-up "
                            style="color: #fff;"></i></button>
                    <button class="down-btn instruction-btn"><i class="fas fa-arrow-alt-circle-down"
                            style="color: #fff;"></i></button>
                    <button class="delete-btn instruction-btn"><i class="fas fa-window-close"
                            style="color: #ffffff;"></i></button>
                </div>
            </div>
            <div class="img-container">
                <img src="{{ asset('assets/img/promo-page/section1.png') }}" alt="Promotion Header"
                    class=" promotion-image">
                <div class="action-container">
                    <button class="edit-btn instruction-btn"><i class="fas fa-edit fa-xs"
                            style="color: #ffffff;"></i></button>
                    <button class="up-btn instruction-btn"><i class="fas fa-arrow-alt-circle-up "
                            style="color: #fff;"></i></button>
                    <button class="down-btn instruction-btn"><i class="fas fa-arrow-alt-circle-down"
                            style="color: #fff;"></i></button>
                    <button class="delete-btn instruction-btn"><i class="fas fa-window-close"
                            style="color: #ffffff;"></i></button>
                </div>
            </div>
            <div class="img-container">
                <img src="{{ asset('assets/img/promo-page/section2.png') }}" alt="Promotion Header"
                    class=" promotion-image">

                <div class="action-container"><button class="edit-btn instruction-btn"><i class="fas fa-edit fa-xs"
                            style="color: #ffffff;"></i></button>
                    <button class="up-btn instruction-btn"><i class="fas fa-arrow-alt-circle-up "
                            style="color: #fff;"></i></button>
                    <button class="down-btn instruction-btn"><i class="fas fa-arrow-alt-circle-down"
                            style="color: #fff;"></i></button>
                    <button class="delete-btn instruction-btn"><i class="fas fa-window-close"
                            style="color: #ffffff;"></i></button>
                </div>
            </div>
            <div class="img-container">
                <img src="{{ asset('assets/img/promo-page/section3.png') }}" alt="Promotion Header"
                    class=" promotion-image">

                <div class="action-container"><button class="edit-btn instruction-btn"><i class="fas fa-edit fa-xs"
                            style="color: #ffffff;"></i></button>
                    <button class="up-btn instruction-btn"><i class="fas fa-arrow-alt-circle-up "
                            style="color: #fff;"></i></button>
                    <button class="down-btn instruction-btn"><i class="fas fa-arrow-alt-circle-down"
                            style="color: #fff;"></i></button>
                    <button class="delete-btn instruction-btn"><i class="fas fa-window-close"
                            style="color: #ffffff;"></i></button>
                </div>
            </div>
            <div class="img-container">
                <img src="{{ asset('assets/img/promo-page/section4.png') }}" alt="Promotion Header"
                    class=" promotion-image">

                <div class="action-container"><button class="edit-btn instruction-btn"><i class="fas fa-edit fa-xs"
                            style="color: #ffffff;"></i></button>
                    <button class="up-btn instruction-btn"><i class="fas fa-arrow-alt-circle-up "
                            style="color: #fff;"></i></button>
                    <button class="down-btn instruction-btn"><i class="fas fa-arrow-alt-circle-down"
                            style="color: #fff;"></i></button>
                    <button class="delete-btn instruction-btn"><i class="fas fa-window-close"
                            style="color: #ffffff;"></i></button>
                </div>
            </div>
        </section>
        <section class="action-instruction hidden" id="action-instruction">
            <div class="content">
                <h2>Instruction in Editing</h2>
                <hr>
                <article class="important">
                    <small> ! Untuk mobile, tombol action akan muncul saat gambar yang akan di edit di sentuh</small>
                </article>
                <article class="instruction">
                    <button class="edit-btn instruction-btn"><i class="fas fa-edit fa-xs"
                            style="color: #ffffff;"></i></button>
                    <p>Untuk mengubah gambar yang ada anda bisa menekan tombol ini.</p>
                </article>
                <article class="instruction">
                    <button class="up-btn instruction-btn"><i class="fas fa-arrow-alt-circle-up "
                            style="color: #fff;"></i></button>
                    <p>Untuk mengubah posisi/urutan gambar ke atas tekan tombol ini.</p>
                </article>
                <article class="instruction">
                    <button class="down-btn instruction-btn"><i class="fas fa-arrow-alt-circle-down"
                            style="color: #fff;"></i></button>
                    <p>Untuk mengubah posisi/urutan gambar ke bawah tekan tombol ini.</p>
                </article>
                <article class="instruction">
                    <button class="delete-btn instruction-btn"><i class="fas fa-window-close"
                            style="color: #ffffff;"></i></button>
                    <p>Untuk menghapus gambar yang ada tekan tombol ini.</p>
                </article>
                <button class="instruction-close cls">Okay!</button>
            </div>
        </section>

        <section class="fixed-btns">
            <button class="add-new-image" id="add-another-image" title="Add another image in the bottom"><i
                    class="fas fa-plus-square"></i></button>
            <button disabled class="save-change">Save</button>
        </section>
    </main>
@endsection
@push('script')
    @vite('resources/js/app.ts')
@endpush
