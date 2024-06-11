@extends('layouts/user_main')

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
                @if ($periode->registration_status == 'yes')
                    @if (!$candidate)
                        <form action="{{ route('daftar_kandidat_post') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="nim">NIM</label>
                                <input class="form-control form-control-solid" id="nimInput" type="text"
                                    placeholder="NIM" readonly value="{{ Auth::user()->nim }}" name="nim">
                            </div>
                            <div class="mb-3">
                                <label for="nama">Nama</label>
                                <input class="form-control form-control-solid" id="namaInput" type="text"
                                    placeholder="Nama" readonly value="{{ Auth::user()->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="phone">Nomor WA Yang Dapat Dihubungi</label>
                                <input class="form-control form-control-solid" id="phone_input" type="text"
                                    placeholder="0xxxxxxxxxxxx" name="phone" required value="{{ old('phone') }}">
                            </div>
                            <div class="mb-3">
                                <label for="vision">Visi</label>
                                <textarea class="form-control form-control-solid @error('vision') is-invalid @enderror" name="vision" id="vision"
                                    cols="30" rows="5" required>{{ old('vision') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="mission">Misi</label>
                                <textarea class="form-control form-control-solid @error('mission') is-invalid @enderror" name="mission" id="mission"
                                    cols="30" rows="5" required>{{ old('mission') }}</textarea>
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
                                <button type="submit" class="btn btn-primary">Daftar Menjadi Kandidat</button>
                            </div>
                        </form>
                    @else
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-12 text-center">
                                <h1 style="font-size: 70px; font-weight: bold;" class="text-dark">ANDA TELAH MENDAFTAR
                                    SEBAGAI
                                    KANDIDAT</h1>
                                <p style="font-size: 25px; font-weight: bold;" class="text-dark">DATA ANDA SEDANG
                                    DIVERIFIKASI
                                    OLEH ADMIN</p>
                                <p style="font-weight: bold;" class="text-dark">Hubungi <span><a
                                            href="https://wa.me/083839764676" target="_blank">083839764676</a></span> jika
                                    mengalami kendala</p>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="row h-100 justify-content-center align-items-center">
                        <div class="col-12 text-center">
                            <h1 style="font-size: 70px; font-weight: bold;" class="text-dark">PENDAFTARAN SEDANG TIDAK
                                DIBUKA</h1>
                        </div>
                    </div>
                @endif
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
@endsection
