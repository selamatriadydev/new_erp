@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> BAHANBAKU</h4>
              </div>
              <div class="card-body">
                        <div class="btn-group">
                                <a href="{{route('bahanbaku.index')}}" class="btn btn-success">kembali</a>
                            </div>
            <form action="{{route('bahanbaku.update',$bahanbaku->id)}}" method="POST">
                @csrf
                @method('patch')
                    <div class="form-body">

                                <div class="form-group">
                                    <label for="">Nama Bahan baku</label>
                                <input type="text" name="nama_bahanbaku" value="{{$bahanbaku->nama_bahanbaku}}" placeholder="Masukan Nama" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Harga PK</label>
                                <input type="text" name="harga_pk" value="{{$bahanbaku->harga_pk}}" placeholder="Masukan Nama" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Harga UP</label>
                                <input type="text" name="harga_up" value="{{$bahanbaku->harga_up}}" placeholder="Masukan Nama" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Berat</label>
                                <input type="text" name="berat" value="{{$bahanbaku->berat}}" placeholder="Masukan Nama" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Berat</label>
                                    <select name="id_satuan" class="form-control">
                                                <option value="" disabled selected>--Pilih Satuan--</option>
                                                @foreach($satuan as $sat)
                                                    <option value="{{$sat->id}}">{{$sat->nama_satuan}}</option>
                                                @endforeach
                                    </select>                                
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
