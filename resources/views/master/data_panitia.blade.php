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
        @if (session()->has('errors'))
            @foreach (session('errors')->all() as $e)
                <div class="alert alert-danger" role="alert">
                    {{ $e }}
                </div>
            @endforeach
        @endif

        {{-- Tambah Panitia --}}
        <div class="card shadow mb-4">
            <a href="#tambahPanitiaCard" class="d-block card-header py-3" data-toggle="collapse" role="button"
                aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Panitia</h6>
            </a>
            <div class="collapse {{ request('nim') ? 'show' : '' }}" id="tambahPanitiaCard">
                <div class="card-body">
                    <form action="">
                        <div class="row">
                            <div class="col-12 col-md-10 mb-3">
                                <input class="form-control form-control-solid" id="nimInput" type="text"
                                    placeholder="NIM" name="nim" required>
                            </div>
                            <div class="col-12 col-md-2 mb-3">
                                <button type="submit" class="btn btn-primary">Cari Data</button>
                            </div>
                        </div>
                    </form>

                    @if ( $search)
                        <hr>
                        <form action="{{ route('panitia.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nim">NIM</label>
                                <input class="form-control form-control-solid" id="nimInput" type="text"
                                    placeholder="NIM" name="nim" required readonly value="{{  $search->nim }}">
                            </div>
                            <div class="mb-3">
                                <label for="nama">Nama</label>
                                <input class="form-control form-control-solid" id="namaInput" type="text"
                                    placeholder="Nama User" name="name" required readonly
                                    value="{{  $search->name }}">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    @endif
                    @if (request('nim') && ! $search)
                        <p>Data tidak ditemukan. User telah menjadi panitia atau sudah mendaftar menjadi kandidat</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Table Data Panitia -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-end">
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
                                @foreach ($committee as $d)
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
