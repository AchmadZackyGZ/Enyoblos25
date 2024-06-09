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
                <div class="d-flex flex-wrap justify-content-end" style="gap: 5px">
                    <a href="{{ route('kandidat.create') }}" class="btn btn-primary">Tambah Kandidat</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataKandidat" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $k)
                                <tr>
                                    <td>{{ $k->user->nim }}</td>
                                    <td>{{ $k->user->name }}</td>
                                    <td><span
                                            class="badge badge-pill badge-{{ $k->status == 'yes' ? 'success' : 'danger' }}">{{ $k->status == 'yes' ? 'Sudah Diverifikasi' : 'Belum Diverifikasi' }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('kandidat.show', $k->id) }}" class="btn btn-primary mx-1"
                                                data-toggle="tooltip" title="Cek Kelengkapan"><i class="fas fa-eye"></i></a>
                                            <form action="{{ route('kandidat.destroy', $k->id) }}" method="post"
                                                class="mx-1">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger" data-toggle="tooltip"
                                                    title="Hapus"><i class="fas fa-trash"></i></button>
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

    @push('scripts')
        <!-- Page level plugins -->
        <script src="{{ asset('/') }}assets/vendor/sb-admin/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="{{ asset('/') }}assets/vendor/sb-admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script>
            // Call the dataTables jQuery plugin
            $(document).ready(function() {
                $('#dataKandidat').DataTable();
            });
        </script>
    @endpush
@endsection
