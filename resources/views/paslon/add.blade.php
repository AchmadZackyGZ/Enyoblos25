@extends('layouts/admin_main')
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header"></div>
            <div class="card-body"> 

                @if (session()->has('errors'))
                        @foreach (session('errors')->all() as $e)
                            <div class="alert alert-danger" role="alert">
                                {{ $e }}
                            </div>
                        @endforeach
                @endif

                    <form action="{{ route('paslon.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">    
                            <label for="chairman">Ketua</label>
                            <select class="form-control" id="chairman" name="chairman">
                                @foreach ($data as $item)
                                <option value="{{ $item->id }}">{{ $item->user->name }}</option>
                                @endforeach 
                              </select> 
                        </div>

                        <div class="mb-3">    
                            <label for="vicechairman">Wakil Ketua</label>
                            <select class="form-control" id="vicechairman" name="vicechairman">
                                @foreach ($data as $item)
                                <option value="{{ $item->id }}">{{ $item->user->name }}</option>
                                @endforeach 
                              </select> 
                        </div>

                        <div class="mb-3">
                            <label for="vision">Visi</label>
                            <textarea class="form-control" id="vision" name="vision" rows="3"></textarea>
                        </div> 

                        <div class="mb-3">
                            <label for="mission">Misi</label>
                            <textarea class="form-control" id="mission" name="mission" rows="3"></textarea>
                        </div> 

                        <div class="mb-3">
                            <label for="photo">Foto Pamflet</label>
                            <input class="form-control" type="file" name="photo">
                        </div> 
                        
                         
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Tambah Kandidat</button>
                        </div>
                    </form>
                
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
@endsection