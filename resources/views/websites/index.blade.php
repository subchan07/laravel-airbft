@extends('layouts.main-dashboard')
@section('container-content')
    <main class="content-wrapper p-2">
        <section class="card p-2">
            <h3>Websites</h3>
        </section>
        <section class="mt-2 p-2 card">
            <div class="d-flex justify-content-end">
                <a href="{{ route('website.create') }}" data-id="clone-btn" class="btn-primary btn">Add Another</a>
            </div>
            <div class="table-responsive mt-2">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 20px">No.</th>
                            <th>Title</th>
                            <th>Page Site URL</th>
                            <th style="width: 200px">Site Section</th>
                            <th style="width: 200px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($websites as $website)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $website->title }}</td>
                                <td> {{ $loop->index === 0 ? '/' : '/' . $website->slug }} </tf>
                                <td><a href="{{ $loop->index === 0 ? route('admin.home') : route('main_page', ['mainPage' => 'home', 'website' => $website->slug]) }}"
                                        class="btn btn-secondary">View Site Sections</a></td>
                                <th><button @disabled($loop->index === 0) class="btn btn-danger" data-toggle="modal"
                                        data-target="#deleteConfirmation{{ $website->id }}">Hapus</button>
                                    @if ($loop->index > 0)
                                        <a href="{{ route('website.edit', $website->id) }}"
                                            class="btn btn-secondary">Edit</a>
                                    @endif
                                </th>
                            </tr>
                            <div class="modal fade" id="deleteConfirmation{{ $website->id }}" tabindex='-1' role="dialog"
                                aria-labelledby="deleteConfirmationLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteConfirmationLabel">Delete Confirmation</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete "{{ $website->title }}"
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancel</button>
                                            <form action="{{ route('website.destroy', $website->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
@endsection
@push('script')
@endpush
