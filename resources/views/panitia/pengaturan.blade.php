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
                        <label for="name">Nama Pemilihan</label>
                        <input class="form-control form-control-solid" id="name" type="text"
                            placeholder="Nama Pemilihan" value="{{ $data->name }}" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="year">Tahun</label>
                        <input class="form-control form-control-solid" id="year" type="number" placeholder="2023"
                            value="{{ $data->year }}" name="year" required>
                    </div>
                    <div class="mb-3">
                        <label for="registration_status">Status Pendaftaran</label>
                        <select name="registration_status" id="registration_status" class="form-control form-control-solid"
                            required>
                            <option value="yes" {{ $data->registration_status == 'aktif' ? 'selected' : '' }}>Aktif
                            </option>
                            <option value="no" {{ $data->registration_status == 'tidak_aktif' ? 'selected' : '' }}>
                                Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="registration_page">Halaman Pendaftaran User</label>
                        <select name="registration_page" id="registration_page" class="form-control form-control-solid"
                            required>
                            <option value="active" {{ $data->registration_page == 'aktif' ? 'selected' : '' }}>Aktif
                            </option>
                            <option value="notActive" {{ $data->registration_page == 'tidak_aktif' ? 'selected' : '' }}>
                                Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="election_status">Status Pemilihan</label>
                        <select name="election_status" id="election_status" class="form-control form-control-solid"
                            required>
                            <option value="yes" {{ $data->election_status == 'aktif' ? 'selected' : '' }}>Aktif
                            </option>
                            <option value="no" {{ $data->election_status == 'tidak_aktif' ? 'selected' : '' }}>
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
