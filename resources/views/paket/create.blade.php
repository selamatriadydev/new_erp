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
            <form action="{{route('paket.store')}}" method="POST" enctype="multipart/form-data">
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
            <div class="form-body">
                                <input type="hidden" name="cabang_id" value="{{Auth::user()->cabang_id}}">
                                <div class="form-group">
                                    <label for="">Code Paket</label>
                                <input type="text" name="code_paket" value="{{$kode}}" placeholder="Masukan Nama" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Paket</label>
                                <input type="text" name="nama_paket" placeholder="Masukan Nama" class="form-control">
                                </div>
                                <!-- <div class="form-group">
                                    <label for="">Hpp</label>
                                <input type="text" name="hpp" placeholder="Masukan Nama" class="form-control">
                                </div>-->
                                <div class="form-group">
                                    <label for="">Harga Jual</label>
                                <input type="text" name="harga_jual" placeholder="Masukan harga jual" class="form-control">
                                </div> 
                                <div class="form-group">
                                    <label for="">Jenis Paket</label>
                                    <select name="jenis_paket" class="form-control">
                                        <option value="" disabled selected>--Pilih Item--</option>
                                        <option value="Biasa">Biasa</option>
                                        <option value="Khusus">Khusus</option>
                                    </select>  
                                </div>
                                <div class="form-group">
                                    <label for="">Komponen</label>
                                    <select name="code_komponen" class="form-control">
                                                <option value="" disabled selected>--Pilih Item--</option>
                                                @foreach($komponen as $kom)
                                                    <option value="{{$kom->code_komponen}}">{{$kom->nama_komponen}}</option>
                                                @endforeach
                                            </select>  
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

@endpush
@endsection