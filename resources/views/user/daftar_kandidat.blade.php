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
                @if ($pengaturan->status_pendaftaran == 'aktif')
                    @if (!$userKandidat)
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
                                <label for="nomor_wa">Nomor WA Yang Dapat Dihubungi</label>
                                <input class="form-control form-control-solid" id="nomor_wa_input" type="text"
                                    placeholder="0xxxxxxxxxxxx" name="nomor_wa" required value="{{ old('nomor_wa') }}">
                            </div>
                            <div class="mb-3">
                                <label for="visi">Visi</label>
                                <textarea class="form-control form-control-solid @error('visi') is-invalid @enderror" name="visi" id="visi"
                                    cols="30" rows="5" required>{{ old('visi') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="misi">Misi</label>
                                <textarea class="form-control form-control-solid @error('misi') is-invalid @enderror" name="misi" id="misi"
                                    cols="30" rows="5" required>{{ old('misi') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="pdf_ktm">PDF KTM Pendukung (.pdf)</label>
                                <input class="form-control form-control-solid" type="file" name="pdf_ktm" id="pdf_ktm"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="suket_organisasi">Surat Keterangan Organisasi (.pdf)</label>
                                <input class="form-control form-control-solid" type="file" name="suket_organisasi"
                                    id="suket_organisasi" required>
                            </div>
                            <div class="mb-3">
                                <label for="suket_lkmm_td">Surat Keterangan LKMM TD (.pdf)</label>
                                <input class="form-control form-control-solid" type="file" name="suket_lkmm_td"
                                    id="suket_lkmm_td" required>
                            </div>
                            <div class="mb-3">
                                <label for="transkrip_nilai">Transkrip Nilai (.pdf)</label>
                                <input class="form-control form-control-solid" type="file" name="transkrip_nilai"
                                    id="transkrip_nilai" required>
                            </div>
                            <div class="mb-3">
                                <label for="foto">Foto 4x6 (.jpg, .png)</label>
                                <input class="form-control form-control-solid" type="file" name="foto" id="foto"
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
                                            href="https://wa.me/083839764676" target="_blank">08xxxxxxxxx</a></span> jika
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
