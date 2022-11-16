@extends('layouts/master')
@section('content')

<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> INPUT INVENTORY PREMIX</h4>
              </div>
              <div class="card-body">
                        <div class="btn-group">
                                <a href="{{route('master')}}" class="btn btn-success">kembali</a>
                            </div>
            <form action="{{route('storepremix')}}" method="POST" enctype="multipart/form-data">
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
                                <div class="row">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="">Code Barang</label>
                                    <input type="text" name="kode_barang" placeholder="Enter subject" class="form-control" value="{{$kode}}" readonly/>         
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="">Margin Premix</label>
                                    <input type="number" name="margin_premix" placeholder="%" class="form-control" />         
                                    </div>
                                    </div>
                                    </div>
                                <div class="row">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="">Nama Barang</label>
                                    <input type="text" name="nama_barang" placeholder="Enter subject" class="form-control" />         
                                    </div>
                                    </div>
                                    <!--  <div class="col-md-6">-->
                                    <!--<div class="form-group">-->
                                    
                                    <!--</div>-->
                                    <!--</div>-->
                                    
                                     <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="">Harga Jual</label>
                                    <input type="text" name="harga_up" placeholder="Harga Jual" class="form-control" />         
                                    </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="">Berat</label>
                                    <input type="number" name="berat" placeholder="Enter Berat" class="form-control" required>
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="">Satuan</label>
                                    <select name="id_satuan" class="form-control">
                                                <option value="" disabled selected>--Pilih Satuan--</option>
                                                @foreach($satuan as $satuans)
                                                    <option value="{{$satuans->id}}">{{$satuans->nama_satuan}}</option>
                                                @endforeach
                                    </select>
                                    </div>
                                    </div>
                                </div>
                               
                                
                                
                                <!-- <div class="form-group">
                                    <label for="">Berat</label> -->
                                    <input type="hidden" name="stok" value="0" class="form-control" >
                                    
                                    <input type="hidden" name="id_kat" value="6" class="form-control" >
                                <!-- </div> -->
                                <div class="row">
                                    <div class="col-md-12">
                                    <table class="table table-bordered" id="dynamicAddRemove">
                                    <tr>
                                    <th>Komponen Bahanbaku</th>
                                    <th>Berat</th>
                                    <th>Action</th>
                                    </tr>
                                    <tr>
                                    <td>
                                    <select name="addmore[0][id_barang]" class="form-control">
                                                <option value="" disabled selected>--Pilih Bahanbaku--</option>
                                                @foreach($id_barang as $id_barangs)
                                                    <option value="{{$id_barangs->id}}">{{$id_barangs->nama_barang}} {{$id_barangs->berat}} {{$id_barangs->nama_satuan}}</option>
                                                @endforeach
                                               
                                    </select>
                                    </td>
                                    <td><input type="text" name="addmore[0][berat]" placeholder="Enter subject" class="form-control" />
                                    </td>
                                    <td><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">Add Subject</button></td>
                                    </tr>
                                    </table>
                                    </div>
                                </div>
                                
                                
                                
                                
                                
            <!-- <div class="table-responsive calculate-rows"> -->
            
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3">
                <button type="submit" class="btn" id="update-payment">Save</button>
                </div>
            </div>
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

        $("#dynamicAddRemove").append('<tr><td><select name="addmore['+i+'][id_barang]" class="form-control"><option value="" disabled selected>--Pilih Bahanbaku--</option> @foreach($id_barang as $id_barangs)<option value="{{$id_barangs->id}}">{{$id_barangs->nama_barang}} {{$id_barangs->berat}} {{$id_barangs->nama_satuan}}</option>@endforeach</select></td><td><input type="text" name="addmore['+i+'][berat]" placeholder="Enter subject" class="form-control" /></td><td><button type="button" name="add" id="remove-input-field" class="btn btn-danger">Remove</button></td></tr>'
            );
    });
    $(document).on('click', '#remove-input-field', function () {
        $(this).parents('tr').remove();
    });
</script>
@endpush
@endsection