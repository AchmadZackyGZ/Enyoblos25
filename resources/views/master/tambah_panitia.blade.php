@extends('layouts/admin_main')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            </div>
            <div class="card-body">
                @if (session()->has('errors'))
                    @foreach (session('errors')->all() as $e)
                        <div class="alert alert-danger" role="alert">
                            {{ $e }}
                        </div>
                    @endforeach
                @endif
                <form action="">
                    <div class="row">
                        <div class="col-12 col-md-10 mb-3">
                            <input class="form-control form-control-solid" id="nimInput" type="text" placeholder="NIM"
                                name="nim" required>
                        </div>
                        <div class="col-12 col-md-2 mb-3">
                            <button type="submit" class="btn btn-primary">Cari Data</button>
                        </div>
                    </div>
                </form>

                @if ($hasilSearch)
                    <hr>
                    <form action="{{ route('panitia.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nim">NIM</label>
                            <input class="form-control form-control-solid" id="nimInput" type="text" placeholder="NIM"
                                name="nim" required readonly value="{{ $hasilSearch->nim }}">
                        </div>
                        <div class="mb-3">
                            <label for="nama">Nama</label>
                            <input class="form-control form-control-solid" id="namaInput" type="text"
                                placeholder="Nama User" name="name" required readonly value="{{ $hasilSearch->name }}">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                @endif
                @if (request('nim') && !$hasilSearch)
                    <p>Data tidak ditemukan. User telah menjadi panitia atau sudah mendaftar menjadi kandidat</p>
                @endif
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
@endsection
