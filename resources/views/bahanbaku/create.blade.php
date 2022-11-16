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
            <form action="{{route('bahanbaku.store')}}" method="POST" enctype="multipart/form-data">
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
                    <th>Nama Bahan baku</th>
                    <th>Harga PK</th>
                    <th>Margin</th>
                    <th>Berat</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="addmore[0][nama_bahanbaku]" placeholder="Enter subject" class="form-control" />
                    </td>
                    <td><input type="text" name="addmore[0][harga_pk]" placeholder="Enter subject" class="form-control" />
                    </td>
                    <td><input type="text" name="addmore[0][harga_up]" placeholder="Enter subject" class="form-control" />
                    </td>
                    <td><input type="text" name="addmore[0][berat]" placeholder="Enter subject" class="form-control" />
                    </td>
                    <td>
                    <select name="addmore[0][id_satuan]" class="form-control">
                                                <option value="" disabled selected>--Pilih Satuan--</option>
                                                @foreach($satuan as $sat)
                                                    <option value="{{$sat->id}}">{{$sat->nama_satuan}}</option>
                                                @endforeach
                        </select>
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
        $("#dynamicAddRemove").append('<tr><td><input type="text" name="addmore['+i+'][nama_bahanbaku]" placeholder="Enter subject" class="form-control" /></td><td><input type="text" name="addmore['+i+'][harga_pk]" placeholder="Enter subject" class="form-control" /></td><td><input type="text" name="addmore['+i+'][harga_up]" placeholder="Enter subject" class="form-control" /></td><td><input type="text" name="addmore['+i+'][berat]" placeholder="Enter subject" class="form-control" /></td><td>   <select name="addmore['+i+'][id_satuan]" class="form-control"><option value="" disabled selected>--Pilih Satuan--</option>@foreach($satuan as $sat)<option value="{{$sat->id}}">{{$sat->nama_satuan}}</option>@endforeach</select><td><button type="button" name="add" id="remove-input-field" class="btn btn-danger">Remove</button></td></tr>'
            );
    });
    $(document).on('click', '#remove-input-field', function () {
        $(this).parents('tr').remove();
    });
</script>
@endpush
@endsection