@extends('layouts/user_main')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if ($periode->election_status == 'yes')
        @if (!$voter)
            <div class="container-fluid">
                <center>
                    <h1>{{ $periode->name }} {{ $periode->year }}</h1>
                </center>
                @if ($isUserKandidat)
                    <div class="alert alert-danger" role="alert">
                        Anda telah mendaftar sebagai kandidat, tidak diperbolehkan melakukan voting.
                    </div>
                @endif
                <div class="row justify-content-center my-0 my-md-3">
                    @foreach ($kandidat as $k)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 text-center">
                                    {{ $loop->iteration }}
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="">
                                            <img src="{{ asset('storage/' . $k->photo) }}" alt="" width="288"
                                                height="432">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Nama</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $k->user->name }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">NIM</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $k->user->nim }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-primary mx-1" data-toggle="modal"
                                            data-target="#kandidat-{{ $k->id }}">Visi & Misi</a>
                                        @if (!$isCandidate)
                                            <a href="#" class="btn btn-success mx-1" data-toggle="modal"
                                                data-target="#pilih-kandidat-{{ $k->id }}">Pilih</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Pilih & Visi Misi --}}
                        <div class="modal fade" id="kandidat-{{ $k->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">VISI & MISI</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">VISI</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{!! nl2br($k->vision) !!}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">MISI</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{!! nl2br($k->mission) !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="pilih-kandidat-{{ $k->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Pilih Kandidat</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h5>Apa anda yakin ingin memilih <b>{{ $k->user->name }}</b> ?</h5>
                                        <p class="text-danger">*Pilihan anda tidak bisa dirubah</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                                        <form action="{{ route('vote_kandidat', $k->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                Pilih
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="container-fluid h-100">
                <div class="row h-100 justify-content-center align-items-center">
                    <div class="col-12 text-center">
                        <h1 style="font-size: 70px; font-weight: bold;" class="text-dark">TERIMA KASIH TELAH MELAKUKAN
                            VOTING!
                        </h1>
                        <p style="font-size: 25px; font-weight: bold;" class="text-dark">SILAHKAN LOGOUT</p>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="container-fluid h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-12 text-center">
                    <h1 style="font-size: 70px; font-weight: bold;" class="text-dark">TIDAK ADA PEMILIHAN</h1>
                    <p style="font-size: 25px; font-weight: bold;" class="text-dark">SILAHKAN LOGOUT</p>
                </div>
            </div>
        </div>
    @endif
@endsection
