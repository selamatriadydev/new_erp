@extends('layouts/master')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">ORDER</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">User Baru</li>
            </ol>
        <!-- <a href="{{route('order.index')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a> -->
        </div>
    </div>
</div>
@if(session('pesan'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
<strong>{{session('pesan')}}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="m-b-0 text-white">New Order</h4>
            </div>
            <div class="card-body">
            <form action="{{route('order.store')}}" method="POST">
                @csrf
                <div class="row">
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header bg-info">
                                    <h4 class="m-b-0 text-white">Product</h4>
                                </div>
                                <div class="card-body">

                                        <div class="row">
                                        <div class="table-responsive m-t-40">
                                            <table id="table" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Paket</th>
                                                        <!-- <th>Cabang</th> -->
                                                        <!-- <th>item</th> -->
                                                        <th>harga</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($product as $item)
                                                    <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$item->nama_product}}</td>
                                                    <!-- <td>{{$item->nama_cabang}}</td> -->
                                                    <!-- <td>{{$item->isi}}</td> -->
                                                    <td>@currency($item->harga)</td>
                                                    <td>
                                                        <div class="btn-group">
                                                        <a href="{{route('addcart',$item->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                                        </div>
                                                    </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            </div>
                                            </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                                <div class="card">
                                <div class="card-header bg-info">
                                        <i class="fas fa-cart-arrow-down text-white">Cart</i>
                                </div>
                                <div class="btn-group">
                                                        <a href="{{route('order.create')}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                                        </div>
                                <div class="card-body">
                                <div class="table-responsive m-t-30">
                                            <table id="user" class="table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <!-- <th>No</th> -->
                                                        <th>Paket</th>
                                                        <!-- <th>Cabang</th> -->
                                                        <th scope="col" style="width:50px">qty</th>
                                                        <th>Cut</th>
                                                        <th>Disc</th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($cart as $cr)
                                                    <tr>
                                                    
                                                    <td>{{$cr->id_paket}}</td>
                                                    <td scope="col" style="width:50px">
                                                    <!-- {{$cr->qty}} -->
                                                        <form action="{{route('cart.update',$cr->id)}}" method="post">
                                                        @csrf
                                                        @method('patch')
                                                            <input type="text" name="qty" style="width: 80px; text-align:center; border: none; border-bottom: 1px solid grey;" value="{{$cr->qty}}">                                                        
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form action="" method="post">
                                                            <input type="text" style="width: 80px; text-align:center; border: none; border-bottom: 1px solid grey;" value="{{$cr->qty}}">
                                                        </form>
                                                    </td>
                                                    <td>
                                                    <form action="" method="post">
                                                            <input type="text" style="width: 80px; text-align:center; border: none; border-bottom: 1px solid grey;" value="{{$cr->qty}}">
                                                        </form>
                                                    </td>
                                                    <!-- <td>@currency($cr->harga)</td> -->
                                                    <td>@currency($cr->subtotal)</td>
                                                    <td>
                                                    <div class="btn-group">
                                                    <form action="{{route('delete',$cr->id)}}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                    </div>
                                                    </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            </div>
                                </div>
                                </div>
                                </div>
                </div>
                <div class="row">
                                <div class="col-md-6">
                                <div class="card">
                                <div class="card-body">
                                    <label for="">No Order</label>
                                    <input type="text" name="no_inv" id="no_inv" value="" class="form-control" readonly>
                                    <label for="">Nama Customer</label>
                                    <input type="text" name="nama_cust" id="no_inv" value="" class="form-control" placeholder="Masukan Nama"> 
                                    <label for="">Cabang</label>
                                            <select name="cabang_id" class="form-control">
                                                <option value="" disabled selected>--Pilih Cabang--</option>
                                                
                                    </select> 
                                    <label for="">Tanggal Kirim</label>
                                    <input type="date" name="tgl_kirim" value="" class="form-control" placeholder="Pilih Tanggal"> 
                                    <label for="">Jam Kirim</label>
                                    <input type="time" name="jam_kirim" value="" class="form-control" placeholder="Tentukan Jam"> 
                                    <label for="">HP</label>
                                    <input type="text" name="no_hp" value="" class="form-control" placeholder="Masukan NO HP Cust"> 
                                    <label for="">Alamat</label>
                                    <textarea class="form-control"  name="alamat" placeholder="Alamat"></textarea> 
 
                                </div>
                                </div>
                                </div>
                                <!-- ========================= -->
                                <div class="col-md-6">
                                <div class="card">
                                <div class="card-body">
                                    <label for="">Jenis Order</label>
                                    <select name="jenis_order" class="form-control">
                                        <option>--Jenis Order--</option>
                                        <option value="Online">Online</option>
                                        <option value="Offline">Offline</option>
                                    </select>
                                    <label for="">Discount</label>
                                    <input type="text" name="no_inv" id="no_inv" value="" class="form-control" placeholder="Masukan Data"> 
                                    <label for="">Potongan</label>
                                    <input type="text" name="no_inv" id="no_inv" value="" class="form-control" placeholder="Masukan Data"> 
                                    <label for="">Big Total</label>
                                    
                                    <input type="text" name="no_inv" id="no_inv" value="" class="form-control" placeholder="Masukan Data" readonly> 
                                    <label for="">Bayar</label>
                                    <input type="text" name="no_inv" id="no_inv" value="" class="form-control" placeholder="Masukan Data"> 
                                    <label for="">Sisa</label>
                                    <input type="text" name="no_inv" id="no_inv" value="" class="form-control" placeholder="Masukan Data"> 
                                    <label for="">Keterangan</label>
                                    <textarea class="form-control"  name="keterangan" placeholder="Keterangan"></textarea> 
                                </div>
                                </div>
                                </div>
                        </div>
            <button type="submit" class="btn btn-outline-success btn-block">Save</button>
        </form>
            
            
                        
            </div>
        </div>
    </div>
</div>
<!-- @push('myjs')
<script>
    $('table').DataTable({
        "scrollX": 300,
        "scrollY": 300,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });
</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
    var i = 0;
    $("#dynamic-ar").click(function () {
        ++i;
        $("#dynamicAddRemove").append('<tr><td><select name="addmore['+i+'][id_paket]" class="form-control"><option value="" disabled selected>--Pilih Paket--</option>@foreach($product as $pr)<option value="{{$pr->id}}">{{$pr->nama_product}}</option>@endforeach</select></td><td> <select name="addmore['+i+'][id_item]" class="form-control"><option value="" disabled selected>--Pilih Paket--</option>@foreach($product as $pr)<option value="{{$pr->id}}">{{$pr->nama_product}}</option>@endforeach</select></td><td><input type="text" name="addmore['+i+'][harga]" placeholder="Enter subject" class="form-control" /></td><td><input type="text" name="addmore['+i+'][qty]" placeholder="Enter subject" class="form-control" /></td><td><input type="text" name="addmore['+i+'][disc]" placeholder="Enter subject" class="form-control" /></td><td><input type="text" name="addmore['+i+'][cut]" placeholder="Enter subject" class="form-control" /></td><td><input type="text" id="total" name="addmore['+i+'][total]" placeholder="Enter subject" class="form-control" /></td><td><button type="button"  id="remove-input-field" class="btn btn-danger">Del</button></td></tr>');
            
    });
    $(document).on('click', '#remove-input-field', function () {
        $(this).parents('tr').remove();
    });
   

</script>
<script>
// start
    $(document).ready(function() {
        $("addmore['+i+'][harga], addmore['+i+'][qty]").keyup(function() {
            var harga1  = $("addmore['+i+'][harga]").val();
            var qty = $("addmore['+i+'][qty]").val();
    
            var tot1 = parseInt(harga1) * parseInt(qty);

             $("addmore['+i+'][total]").val(tot1);
        });
    });
</script>
@endpush -->
@endsection