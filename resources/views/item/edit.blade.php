@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> ITEM</h4>
              </div>
              <div class="card-body">
                        <div class="btn-group">
                                <a href="{{route('item.index')}}" class="btn btn-success">kembali</a>
                            </div>
            <form action="{{route('item.update',$item->id)}}" method="POST">
                @csrf
                @method('patch')
                    <div class="form-body">
                                <div class="form-group">
                                    <label for="">Code Item</label>
                                <input type="text" name="code_item" value="{{$item->code_item}}" placeholder="Masukan Nama" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">item</label>
                                <input type="text" name="nama_item" value="{{$item->nama_item}}" placeholder="Masukan Nama" class="form-control">
                                </div>
                                 <div class="form-group">
                                   <label for="">Hpp</label>
                                <input type="text" name="hpp" value="{{$item->hpp}}" placeholder="Masukan Hpp" class="form-control">
                                </div>
                                <div class="form-group">
                                   <label for="">Harga</label>
                                <input type="text" name="harga_jual" value="{{$item->harga_jual}}" placeholder="Masukan Harga" class="form-control">
                                </div>
                                 <div class="form-group">
                                    <label for="">Resep</label>
                                    <select name="id_resep" class="form-control">
                                                <option value="" disabled selected>--Pilih Resep--</option>
                                                @foreach($resep as $pr)
                                                    <option value="{{$pr->id}}">{{$pr->nama_resep}}</option>
                                                @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Kategori</label>
                                    <select name="id_kategori" class="form-control">
                                                <option value="" disabled selected>--Pilih Kategori--</option>
                                                @foreach($kategori as $pr)
                                                    <option value="{{$pr->id}}">{{$pr->kategori}}</option>
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
