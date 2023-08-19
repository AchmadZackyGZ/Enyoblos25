@extends('layouts/admin_main')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pengaturan KPU</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pengaturan Pemilihan</h6>
            </div>
            <div class="card-body">
                @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('pengaturan_post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama">Nama Pemilihan</label>
                        <input class="form-control form-control-solid" id="nama" type="text"
                            placeholder="Nama Pemilihan" value="{{ $data->nama }}" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="tahun">Tahun</label>
                        <input class="form-control form-control-solid" id="tahun" type="number" placeholder="2023"
                            value="{{ $data->tahun }}" name="tahun" required>
                    </div>
                    <div class="mb-3">
                        <label for="status_pendaftaran">Status Pendaftaran</label>
                        <select name="status_pendaftaran" id="status_pendaftaran" class="form-control form-control-solid"
                            required>
                            <option value="aktif" {{ $data->status_pendaftaran == 'aktif' ? 'selected' : '' }}>Aktif
                            </option>
                            <option value="tidak_aktif" {{ $data->status_pendaftaran == 'tidak_aktif' ? 'selected' : '' }}>
                                Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="halaman_pendaftaran">Halaman Pendaftaran User</label>
                        <select name="halaman_pendaftaran" id="halaman_pendaftaran" class="form-control form-control-solid"
                            required>
                            <option value="aktif" {{ $data->halaman_pendaftaran == 'aktif' ? 'selected' : '' }}>Aktif
                            </option>
                            <option value="tidak_aktif" {{ $data->halaman_pendaftaran == 'tidak_aktif' ? 'selected' : '' }}>
                                Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status_pemilihan">Status Pemilihan</label>
                        <select name="status_pemilihan" id="status_pemilihan" class="form-control form-control-solid"
                            required>
                            <option value="aktif" {{ $data->status_pemilihan == 'aktif' ? 'selected' : '' }}>Aktif
                            </option>
                            <option value="tidak_aktif" {{ $data->status_pemilihan == 'tidak_aktif' ? 'selected' : '' }}>
                                Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>
@endsection
