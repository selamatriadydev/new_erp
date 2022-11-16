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
            <form action="{{route('item.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
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
                                    <label for="">Code Item</label>
                                    <input type="text" name="code_item" value="{{$kode}}" placeholder="nama item" class="form-control" required readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Nama Item</label>
                                    <input type="text" name="nama_item" placeholder="nama item" class="form-control" required>
                                </div>
                                 <div class="form-group">
                                    <label for="">Kategori Product</label>
                                    <select name="id_kategori" class="form-control">
                                                <option value="" disabled selected>--Pilih Kategori--</option>
                                                @foreach($kategori as $kat)
                                                    <option value="{{$kat->id}}">{{$kat->kategori}}</option>
                                                @endforeach
                                    </select>                                
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
                                    <label for="">Hpp</label>
                                    <input type="number" name="hpp" placeholder="hpp" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Jual</label>
                                    <input type="number" name="harga_jual" placeholder="jual %" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Gambar</label>
                                    <input type="file" name="gambar" class="form-control">
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
<script type="text/javascript">
    var i = 0;
    $("#dynamic-ar").click(function () {
        ++i;
        $("#dynamicAddRemove").append('<tr><td><input type="text" name="addmore['+i+'][nama_item]" placeholder="Enter subject" class="form-control" /></td><td><input type="text" name="addmore['+i+'][harga]" placeholder="Enter subject" class="form-control" /></td><td><button type="button" name="add" id="remove-input-field" class="btn btn-danger">Remove</button></td></tr>');
    });
    $(document).on('click', '#remove-input-field', function () {
        $(this).parents('tr').remove();
    });
</script>
 <script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
      alert(msg);
    }
  </script>
@endpush
@endsection