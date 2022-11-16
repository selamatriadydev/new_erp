@extends('layouts/master')
@section('content')

<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> INPUT INVENTORY</h4>
              </div>
              <div class="card-body">
                        <div class="btn-group">
                                <a href="{{route('gudangcabang.index')}}" class="btn btn-success">kembali</a>
                            </div>
            <form action="{{route('gudangcabang.store')}}" method="POST" enctype="multipart/form-data">
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
            
            <table class="table table-bordered" id="dynamicAddRemove">
                <tr>
                    <th>Pilih Barang</th>
                    <th>Margin</th>
                    <th>Action</th>
                </tr>
                <tr>
                <td>
                <select name="addmore[0][code_barang_model]" class="form-control">
                                                <option value="" disabled selected>--Pilih Satuan--</option>
                                                @foreach($barang as $sat)
                                                    <option value="{{$sat->code_barang_model}}">{{$sat->nama_barang}} {{$sat->nama_satuan}} || @currency($sat->harga_jual)</option>
                                                @endforeach
                        </select>                
                    </td>
                    <td>
                    <input type="text" name="addmore[0][margin]" placeholder="Enter subject" class="form-control" />                 
                    </td>
                    <td><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">Add Subject</button></td>
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
    $("#dynamic-ar").click(function () {
        ++i;
        $("#dynamicAddRemove").append('<tr><td><select name="addmore['+i+'][code_barang_model]" class="form-control"><option value="" disabled selected>--Pilih Satuan--</option>@foreach($barang as $sat)<option value="{{$sat->code_barang_model}}">{{$sat->nama_barang}} {{$sat->nama_satuan}}|| @currency($sat->harga_jual)</option>@endforeach</select></td><td><input type="text" name="addmore['+i+'][margin]" placeholder="Enter subject" class="form-control" /></td><td><button type="button" name="add" id="remove-input-field" class="btn btn-danger">Remove</button></td></tr>'
            );
    });
    $(document).on('click', '#remove-input-field', function () {
        $(this).parents('tr').remove();
    });
</script>
@endpush
@endsection