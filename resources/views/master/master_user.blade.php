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
                {{-- <h6 class="m-0 font-weight-bold text-primary">Data Pemilih</h6> --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('pemilih.create') }}" class="btn btn-primary mx-1">Tambah Data</a>
                    <a href="#" class="btn btn-primary mx-1" data-toggle="modal"
                        data-target="#importPemilihModal">Import
                        Data</a>
                    <a href="{{ route('kirim_email_all') }}" class="btn btn-primary mx-1">Kirim Email Semua User</a>
                    <a href="{{ route('panitia.download_template_pemilih') }}" class="btn btn-warning mx-1">Template
                        Import</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataPemilih" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Angkatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $u)
                                <tr>
                                    <td>{{ $u->nim }}</td>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>{{ $u->angkatan }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('kirim_email_user', $u->id) }}" class="btn btn-primary mx-1"
                                                data-toggle="tooltip" title="Kirim Email"><i
                                                    class="fas fa-envelope"></i></a>
                                            <a href="#" class="btn btn-warning mx-1" data-toggle="tooltip"
                                                title="Edit Data"><i class="fas fa-pen"></i></a>
                                            <form action="{{ route('user.reset_password', $u->id) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-warning mx-1" data-toggle="tooltip"
                                                    title="Reset Password"><i class="fas fa-key"></i></button>
                                            </form>
                                            <form action="{{ route('user.destroy', $u->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger mx-1" data-toggle="tooltip"
                                                    title="Hapus User"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('modals')
        <div class="modal fade" id="importPemilihModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('pemilih.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import data user</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if (session()->has('errors'))
                                @foreach (session('errors')->all() as $e)
                                    <div class="alert alert-danger" role="alert">
                                        {{ $e }}
                                    </div>
                                @endforeach
                            @endif
                            <div class="mb-3">
                                <label for="fileImport">File Excel (.xlsx)</label>
                                <input class="form-control form-control-solid @error('angkatan') is-invalid @enderror"
                                    id="fileImport" type="file" name="fileImport" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Import</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endpush

    @push('scripts')
        <!-- Page level plugins -->
        <script src="{{ asset('/') }}assets/vendor/sb-admin/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="{{ asset('/') }}assets/vendor/sb-admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script>
            // Call the dataTables jQuery plugin
            $(document).ready(function() {
                $('#dataPemilih').DataTable();
            });
        </script>

        @if (session()->has('errors'))
            <script>
                $('#importPemilihModal').modal('toggle')
            </script>
        @endif
    @endpush
@endsection
