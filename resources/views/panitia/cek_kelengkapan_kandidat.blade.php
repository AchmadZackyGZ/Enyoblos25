@extends('layouts/admin_main')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Buat Laporan</a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 text-center">
                        Data Kandidat
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="">
                                <img src="{{ asset('storage/' . $data->photo) }}" alt="Photo" width="288px" height="432px">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Nama</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $data->user->name }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">NIM</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $data->user->nim }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Nomor Whatsapp</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><a href="http://wa.me/{{ $data->phone }}"
                                        target="_blank" rel="noopener noreferrer">{{ $data->phone }}</a></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">VISI</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{!! nl2br($data->vision) !!}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">MISI</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{!! nl2br($data->mission) !!}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">PDF KTM</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">
                                    <a href="{{ route('kandidat.cek_kelengkapan', [$data->id, 'student_card']) }}"
                                        target="_blank" class="btn btn-primary">Cek Kelengkapan</a>
                                    <a href="{{ route('kandidat.download_kelengkapan', [$data->id, 'student_card']) }}"
                                        target="_blank" class="btn btn-warning">Download Kelengkapan</a>
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Surat Keterangan Organisasi</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">
                                    <a href="{{ route('kandidat.cek_kelengkapan', [$data->id, 'organization_letter']) }}"
                                        target="_blank" class="btn btn-primary">Cek Kelengkapan</a>
                                    <a href="{{ route('kandidat.download_kelengkapan', [$data->id, 'organization_letter']) }}"
                                        target="_blank" class="btn btn-warning">Download Kelengkapan</a>
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Surat Keterangan LKMM TD</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">
                                    <a href="{{ route('kandidat.cek_kelengkapan', [$data->id, 'lkmtd_letter']) }}"
                                        target="_blank" class="btn btn-primary">Cek Kelengkapan</a>
                                    <a href="{{ route('kandidat.download_kelengkapan', [$data->id, 'lkmtd_letter']) }}"
                                        target="_blank" class="btn btn-warning">Download Kelengkapan</a>
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Transkrip Nilai</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">
                                    <a href="{{ route('kandidat.cek_kelengkapan', [$data->id, 'transcript']) }}"
                                        target="_blank" class="btn btn-primary">Cek Kelengkapan</a>
                                    <a href="{{ route('kandidat.download_kelengkapan', [$data->id, 'transcript']) }}"
                                        target="_blank" class="btn btn-warning">Download Kelengkapan</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <a href="#"
                                class="btn btn-success {{ $data->status == 'yes' ? 'disabled' : '' }}"
                                data-toggle="modal" data-target="#verifikasiModal">Verifikasi Data</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('modals')
        <!-- Verifikasi Modal-->
        <div class="modal fade" id="verifikasiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">VERIFIKASI DATA</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Tekan tombol verifikasi jika data kandidat sudah lengkap.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <form action="{{ route('kandidat.verifikasi_data', $data->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success">Verifikasi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endpush
@endsection
