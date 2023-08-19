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

                @if ($hasilSearch)
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
                                readonly value="{{ $hasilSearch->nim }}" name="nim">
                        </div>
                        <div class="mb-3">
                            <label for="nama">Nama</label>
                            <input class="form-control form-control-solid" id="namaInput" type="text" placeholder="Nama"
                                readonly value="{{ $hasilSearch->name }}">
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
                            <button type="submit" class="btn btn-primary">Tambah Kandidat</button>
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
