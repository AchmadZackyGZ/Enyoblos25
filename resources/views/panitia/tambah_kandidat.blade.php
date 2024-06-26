@extends('layouts/admin_main')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header"></div>
            <div class="card-body">
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

                @if ($data)
                    <hr>
                    @if (session()->has('errors'))
                        @foreach (session('errors')->all() as $e)
                            <div class="alert alert-danger" role="alert">
                                {{ $e }}
                            </div>
                        @endforeach
                    @endif
                    <form action="{{ route('kandidat.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nim">NIM</label>
                            <input class="form-control form-control-solid" id="nimInput" type="text" placeholder="NIM"
                                readonly value="{{ $data->nim }}" name="nim">
                        </div>
                        <div class="mb-3">
                            <label for="nama">Nama</label>
                            <input class="form-control form-control-solid" id="namaInput" type="text" placeholder="Nama"
                                readonly value="{{ $data->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="phone">Nomor WA Yang Dapat Dihubungi</label>
                            <input class="form-control form-control-solid" id="phone_input" type="text"
                                placeholder="0xxxxxxxxxxxx" name="phone" required value="{{ old('phone') }}">
                        </div> 
                        <div class="mb-3">
                            <label for="student_card">PDF KTM Pendukung (.pdf)</label>
                            <input class="form-control form-control-solid" type="file" name="student_card" id="student_card"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="organization_letter">Surat Keterangan Organisasi (.pdf)</label>
                            <input class="form-control form-control-solid" type="file" name="organization_letter"
                                id="organization_letter" required>
                        </div>
                        <div class="mb-3">
                            <label for="lkmtd_letter">Surat Keterangan LKMM TD (.pdf)</label>
                            <input class="form-control form-control-solid" type="file" name="lkmtd_letter"
                                id="lkmtd_letter" required>
                        </div>
                        <div class="mb-3">
                            <label for="transcript">Transkrip Nilai (.pdf)</label>
                            <input class="form-control form-control-solid" type="file" name="transcript"
                                id="transcript" required>
                        </div>
                        <div class="mb-3">
                            <label for="photo">Foto 4x6 (.jpg, .png)</label>
                            <input class="form-control form-control-solid" type="file" name="photo" id="photo"
                                required>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Tambah Kandidat</button>
                        </div>
                    </form>
                @endif
                @if (request('nim') && !$data)
                    <p>Data tidak ditemukan. User telah menjadi panitia atau sudah mendaftar menjadi kandidat</p>
                @endif
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
@endsection