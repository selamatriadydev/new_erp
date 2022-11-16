@extends('layouts/master')
@section('content')

<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Input Potongan</h4>
              </div>
              <div class="card-body">
                        <div class="btn-group">
                                <a href="{{route('potongan')}}" class="btn btn-success">kembali</a>
                            </div>
            <form action="{{route('input_potongan')}}" method="POST" enctype="multipart/form-data">
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
            
                                <div class="form-group">
                                    <label for="">Produk</label>
                                     <select name="id_produk" class="form-control">
                                                <option value="" disabled selected>--Pilih Produk--</option>
                                                @foreach($master as $mas)
                                                    <option value="{{$mas->id}}">{{$mas->nama_barang}} {{$mas->nama_satuan}}</option>
                                                @endforeach
                        </select>
                                </div>
            <div class="table-responsive calculate-rows">
            <table class="table table-bordered" id="dynamicAddRemove">
                <tr>
                    <!--<th>Harga Pokok</th>-->
                    <th>From</th>
                    <th>To</th>
                    <th>Potongan</th>
                    <th>Action</th>
                </tr>
                <tr>
                    
                    <td>
                        <input type="text" name="addmore[0][range1]" placeholder="Range 1" class="form-control">
                    </td>
                    <td>
                        <input type="text" name="addmore[0][range2]" placeholder="Range 2" class="form-control" />
                    </td>
                    <td>
                        <input type="text" name="addmore[0][potongan]" placeholder="Potongan" class="form-control" />
                    </td>
                    
                    <td><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">Add</button></td>
                </tr>
            </table>
            <button type="submit" class="btn btn-outline-success btn-block">Save</button>
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
    var no =1;
    $("#dynamic-ar").click(function () {
        ++i;
        ++no;

        $("#dynamicAddRemove").append('<tr><td><input type="text" name="addmore['+i+'][range1]" placeholder="Range 1" class="form-control"></td><td><input type="text" name="addmore['+i+'][range2]" placeholder="Range 2" class="form-control" /></td><td><input type="text" name="addmore['+i+'][potongan]" placeholder="Potongan" class="form-control" /></td><td><button type="button" name="add" id="remove-input-field" class="btn btn-danger">Del</button></td></tr>'
            );
    });
    $(document).on('click', '#remove-input-field', function () {
        $(this).parents('tr').remove();
    });
</script>
@endpush
@endsection