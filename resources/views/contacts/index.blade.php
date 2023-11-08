@extends('layouts.main-dashboard')
@section('container-content')
    <main class="content-wrapper contacts p-3">
        <section id="header" class="header">
            <h1>Contacts</h1>
        </section>
        <section class="contacts-content card p-2">
            <div class="table-responsive">
                <table class="table" id="contact-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>No. Whatsapp</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                    <tbody>
                        @foreach ($contacts as $contact)
                            <tr>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->phone_number }}</td>
                                <td>{{ $contact->address }}</td>
                                <td><a href="https://wa.me/+{{ $contact->phone_number }}"
                                        class="btn btn-outline-primary">Kirim Pesan</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                    </thead>
                </table>
            </div>
        </section>
    </main>
@endsection

@push('script')
    <script src="{{ asset('dashboard-page/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard-page/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard-page/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dashboard-page/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard-page/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dashboard-page/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script>
        let table = new DataTable('#contact-table')
    </script>
@endpush
