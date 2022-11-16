@extends('layouts/master')
@section('content')

<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> SUPPLIER</h4>
              </div>
              <div class="card-body">
                        <div class="btn-group">
                                <a href="{{route('supplier.index')}}" class="btn btn-success">kembali</a>
                            </div>
            <form action="{{route('supplier.update',$supplier->id)}}" method="POST" enctype="multipart/form-data">
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
                                <div class="form-group">
                                    <label for="">Nama Supplier</label>
                                <input type="text" name="nama_supplier" value="{{$supplier->nama_supplier}}" placeholder="Masukan Nama" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">No Hp</label>
                                <input type="text" name="no_hp" value="{{$supplier->no_hp}}" placeholder="Masukan Nama" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat</label>
                                <textarea name="alamat" value="{{$supplier->alamat}}" placeholder="alamat" class="form-control"></textarea>                                
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