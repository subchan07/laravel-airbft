@extends('layouts.main-dashboard')
@section('container-content')
    <main class="content-wrapper p-2">
        <section class="card p-2">
            <h3>Add Another Website</h3>
        </section>
        <section class="mt-2 card p-2">
            <span class="text-danger">! This Website will be cloned from the Main site</span>
            <form method="POST" action="{{ route('website.store') }}">
                @csrf
                <label for="title" class="d-block">Title</label>
                <span class="text-muted">URL for this website/pagesite will be generated based on the title</span>
                <input required type="text" name="title" id="title" class="form-control">
                <div class="mt-2 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </section>
    </main>
@endsection
