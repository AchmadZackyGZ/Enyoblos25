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
                {{-- <h6 class="m-0 font-weight-bold text-primary">Data Pemilih</h6> --}}
            </div>
            <div class="card-body">
                @if (session()->has('errors'))
                    @foreach (session('errors')->all() as $e)
                        <div class="alert alert-danger" role="alert">
                            {{ $e }}
                        </div>
                    @endforeach
                @endif
                <form action="{{ route('pemilih.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nim">NIM</label>
                        <input class="form-control form-control-solid @error('nim') is-invalid @enderror" id="nimInput"
                            type="text" placeholder="NIM" name="nim" required value="{{ old('nim') }}">
                    </div>
                    <div class="mb-3">
                        <label for="nama">Nama</label>
                        <input class="form-control form-control-solid @error('name') is-invalid @enderror" id="namaInput"
                            type="text" placeholder="Nama Pemilih" name="name" required value="{{ old('name') }}">
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input class="form-control form-control-solid @error('email') is-invalid @enderror" id="emailInput"
                            type="email" placeholder="email@domain.com" name="email" required
                            value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label for="angkatan">Angkatan</label>
                        <input class="form-control form-control-solid @error('angkatan') is-invalid @enderror"
                            id="angkatanInput" type="number" placeholder="2023" name="angkatan" required
                            value="{{ old('angkatan') }}">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
@endsection
