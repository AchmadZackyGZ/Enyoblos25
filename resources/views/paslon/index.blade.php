@extends('layouts/admin_main')
@section('content')
<div class="container-fluid">
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-wrap justify-content-end" style="gap: 5px">
                <a href="{{ route('paslon.create') }}" class="btn btn-primary">Tambah Paslon</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataKandidat" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th> 
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($data as $item)
                           <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $item->getDataChairman->user->name . " & ".$item->getDataViceChairman->user->name }}</td>
                              <td>
                                <form action="{{ route('paslon.destroy', $item->id) }}" method="post"
                                    class="mx-1">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger" data-toggle="tooltip"
                                        title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                              </td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection