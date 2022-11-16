@extends('layouts/master')
@section('content')

<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> PAKET</h4>
              </div>
              <div class="card-body">
                        <div class="btn-group">
                                <a href="{{route('paket.index')}}" class="btn btn-success">kembali</a>
                            </div>
            <form action="{{route('paket.ubah')}}" method="POST" enctype="multipart/form-data">
              @csrf
            @method('patch')
            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if (Session::has('success'))
            <div class="alert alert-success text-center">
                <p>{{ Session::get('success') }}</p>
            </div>
            @endif
            <div class="form-body">
                                 <input type="text" name="code_paket" value="{{$paket->code_paket}}" >
                                <div class="form-group">
                                    <label for="">Paket</label>
                                <input type="text" name="nama_paket" value="{{$paket->nama_paket}}" placeholder="Masukan Nama" class="form-control">
                                </div>
                               
                                <div class="form-group">
                                    <label for="">Harga Jual</label>
                                <input type="text" name="harga_jual" value="{{$paket->harga_jual}}" placeholder="Masukan harga jual" class="form-control">
                                </div> 
                               
                               
                                
                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@push('myjs')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>


@endpush
@endsection