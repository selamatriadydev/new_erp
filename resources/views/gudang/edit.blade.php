@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> EDIT INVENTORY</h4>
              </div>
              <div class="card-body">
                        <div class="btn-group">
                                <a href="{{route('gudang.index')}}" class="btn btn-success">kembali</a>
                            </div>
            <form action="{{route('gudang.update',$gudang->id)}}" method="POST">
                @csrf
                @method('patch')
                    <div class="form-body">
                                <div class="form-group">
                                    <label for="">Nama Barang</label>
                                    <input type="text" name="nama_barang" value="{{$gudang->nama_barang}}" placeholder="Masukan Nama" class="form-control">                                
                                </div>
                                <div class="form-group">
                                    <label for="">Harga PK</label>
                                    <input type="text" name="harga_pk" value="{{$gudang->harga_pk}}" placeholder="Masukan Nama" class="form-control">                                
                                </div>
                                <div class="form-group">
                                    <label for="">Berat</label>
                                    <input type="text" name="berat" value="{{$gudang->berat}}" placeholder="Masukan Nama" class="form-control">                                
                                </div>
                                <div class="form-group">
                                    <label for="">Satuan</label>
                                    <select name="id_satuan" value="{{$gudang->id_satuan}}" class="form-control" required>
                                                <option value="" disabled selected>--Pilih Satuan--</option>
                                                @foreach($satuan as $sat)
                                                    <option value="{{$sat->id}}">{{$sat->nama_satuan}}</option>
                                                @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Stok</label>
                                <input type="text" name="stok" value="{{$gudang->stok}}" placeholder="Masukan Nama" class="form-control">
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
