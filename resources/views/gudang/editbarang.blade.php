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
            <form action="{{route('updatebarang',$gudang->id)}}" method="POST">
                @csrf
                @method('patch')
                    <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="">Nama Barang</label>
                                    <input type="text" name="nama_barang" value="{{$gudang->nama_barang}}-{{$gudang->code_barang_model}}" placeholder="Masukan Nama" class="form-control"  readonly>                                
                                </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Harga Pokok</label>
                                            <input type="text"  value="@currency($gudang->harga_pokok)" placeholder="Masukan Nama" class="form-control" readonly>                                
                                        </div>
                                   </div>
                                </div>
                               <div class="row">
                                   
                                   <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Harga Pokok New</label>
                                            <input type="text" name="harga_pokok" value="" placeholder="Masukan Margin" class="form-control">                                
                                        </div>
                                   </div>
                                   <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Margin New</label>
                                            <input type="text" name="margin" value="" placeholder="Masukan Margin" class="form-control">                                
                                        </div>
                                   </div>
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
