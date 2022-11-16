@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> EDIT JENIS PENGELUARAN</h4>
              </div>
              <div class="card-body">
                        <div class="btn-group">
                                <a href="{{route('jenispengeluaran.index')}}" class="btn btn-success">kembali</a>
                            </div>
            <form action="{{route('jenispengeluaran.update',$jenis->id)}}" method="POST">
                @csrf
                @method('patch')
                    <div class="form-body">

                                <div class="form-group">
                                    <label for="">item</label>
                                <input type="text" name="nama_pengeluaran" value="{{$jenis->nama_pengeluaran}}" placeholder="Masukan Nama" class="form-control">
                                </div>
                                



                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
