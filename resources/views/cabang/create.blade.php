@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> CABANG</h4>
              </div>
              <!-- @if(session('pesan'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>{{session('pesan')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif -->
                <div class="card-body">
                            <div class="btn-group">
                                <a href="{{route('cabang.index')}}" class="btn btn-success">back</a>
                            </div>

            <form action="{{route('cabang.store')}}" method="POST">
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
                    <th>Nama Cabang</th>
                    <th>Alamat</th>
                    <th>No Telp</th>
                    <th>Fungsi</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="addmore[0][nama_cabang]" placeholder="Enter subject" class="form-control" />
                    </td>
                    <td>
                        <textarea class="form-control"  name="addmore[0][alamat]"></textarea>
                    </td>
                    <td>
                    <input type="text" name="addmore[0][no_hp]" placeholder="Enter subject" class="form-control" />
                    </td>
                    <td>
                    <select name="addmore[0][fungsi]" class="form-control">
                                                <option value="" disabled selected>--Pilih Fungsi--</option>
                                                <option value="warehouse">Gudang</option>
                                                <option value="toko">Toko</option>
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
        $("#dynamicAddRemove").append('<tr><td><input type="text" name="addmore['+i+'][nama_cabang]" placeholder="Enter subject" class="form-control" /></td><td><textarea class="form-control"  name="addmore['+i+'][alamat]"></textarea></td><td><input type="text" name="addmore['+i+'][no_hp]" placeholder="Enter subject" class="form-control" /></td><td><select name="addmore['+i+'][fungsi]" class="form-control"><option value="" disabled selected>--Pilih Fungsi--</option><option value="warehouse">Gudang</option><option value="toko">Toko</option></select></td><td><button type="button" name="add" id="remove-input-field" class="btn btn-danger">Remove</button></td></tr>');
    });
    $(document).on('click', '#remove-input-field', function () {
        $(this).parents('tr').remove();
    });
</script>

@endpush
@endsection
