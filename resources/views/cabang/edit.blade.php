@extends('layouts/master')
@section('content')

<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> CABANG</h4>
              </div>
              <div class="card-body">
                        <div class="btn-group">
                                <a href="{{route('cabang.index')}}" class="btn btn-success">kembali</a>
                            </div>
            <form action="{{route('cabang.update',$cabang->id)}}" method="POST">
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
                                <div class="form-group">
                                    <label for="">Cabang</label>
                                    <input type="text" name="nama_cabang" value="{{$cabang->nama_cabang}}" placeholder="Masukan Cabang" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat</label>
                                    <input type="text" name="alamat" value="{{$cabang->alamat}}" placeholder="Masukan Hp" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Hp</label>
                                    <input type="text" name="no_hp" value="{{$cabang->no_hp}}" placeholder="Masukan Hp" class="form-control">
                                </div>
                                
                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
