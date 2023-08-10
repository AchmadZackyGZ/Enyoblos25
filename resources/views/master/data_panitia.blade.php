@extends('layouts/admin_main')

@section('content')
    @push('css')
        <link href="{{ asset('/') }}assets/vendor/sb-admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    @endpush

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Buat Laporan</a>
        </div>
        @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('panitia.create') }}" class="btn btn-primary mx-1">Tambah Data</a>
                    <button type="submit" class="btn btn-danger mx-1" form="dataPanitiaForm">Hapus Terpilih</button>
                </div>
            </div>
            <form action="{{ route('panitia.delete_selected') }}" method="post" id="dataPanitiaForm">
                @csrf
                @method('delete')
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataPanitia" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <td>
                                        <center><input type="checkbox" name="selectAll" id="selectAll"></center>
                                    </td>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Angkatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataPanitia as $d)
                                    <tr>
                                        <td>
                                            <center>
                                                <input type="checkbox" name="ids[]" value="{{ $d->id }}">
                                            </center>
                                        </td>
                                        <td>{{ $d->nim }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ $d->email }}</td>
                                        <td>{{ $d->angkatan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <!-- Page level plugins -->
        <script src="{{ asset('/') }}assets/vendor/sb-admin/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="{{ asset('/') }}assets/vendor/sb-admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script>
            // Call the dataTables jQuery plugin
            $(document).ready(function() {
                $('#dataPanitia').DataTable();
            });

            // Select All Script
            $('#selectAll').click(function(event) {
                if (this.checked) {
                    // Iterate each checkbox
                    $(':checkbox').each(function() {
                        this.checked = true;
                    });
                } else {
                    $(':checkbox').each(function() {
                        this.checked = false;
                    });
                }
            });
        </script>
    @endpush
@endsection
