@extends('layouts/master')
@section('content')

<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> SALES ORDER</h4>
              </div>
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
              <div class="card-body">
                        <div class="btn-group">
                                <a href="{{route('bigwarehouse')}}" class="btn btn-success">kembali</a>
                            </div>
            <form action="{{route('purchase.store')}}" method="POST">
                @csrf
                <div class="form-body">

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                    
                                            <div class="card-body">
                                                <label for="">No Sales Order</label>
                                                <input type="text" name="no_order" value="{{$kode}}" class="form-control" readonly>
                                            </div>
                                
                                        </div>
                                        <div class="col-md-6">
                                    
                                            <div class="card-body">
                                                <label for="">Tanggal Transaksi</label>
                                                <input type="date" name="tanggal_transaksi" value="{{$ldate}}" class="form-control" readonly>
                                            </div>
                                
                                        </div>
                                        <div class="col-md-6">
                                    
                                            <div class="card-body">
                                                <label for="">Due Date</label>
                                                <input type="date" name="due_date" value="{{$ldate}}" class="form-control">
                                            </div>
                                
                                        </div>
                                    </div>                    
                                </div>
                                
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <label for="">Customer</label>
                                                <select name="id_customer" class="form-control"> 
                                                  @foreach($pilcab as $user)
                                                  <option value="{{$user->id}}">{{$user->nama}} ({{$user->toko}})</option>
                                                 @endforeach
                                        </select>                                            
                                        </div>
                                        </div>
                                
                                        </div>
                                    </div>                    
                                </div>
                                <!-- <input type="hidden" name="nama_gudang" value="Admin Bigwarehouse">
                                <input type="hidden" name="gudang_peminta" value="{{Auth::user()->hak_akses}}">
                                <input type="hidden" name="from" value="{{Auth::user()->cabang_id}}"> -->
                                <div class="table-responsive calculate-rows">
                                    <table class="table">
                                        <thead>
                                        <a href="#" class="btn newitem btn-primary tooltip-primary"><i class="fa fa-plus"></i> New Item</a>
                                        <tr>
                                            <th style="width:25%;">Produk</th>
                                            <th style="width:21%;">Jumlah</th>
                                            <th style="width:4%;"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="addrow">
                                        <tr class="rows">
                                            <td style="border-top: none;">
                                            <select name="id[]" class="form-control">
                                                <option value="" disabled selected>--Pilih Produk--</option>
                                                @foreach($bahanbaku as $bah)
                                                    <option value="{{$bah->id}}">{{$bah->nama_barang}} {{$bah->berat}} {{$bah->nama_satuan}}</option>
                                                @endforeach
                                            </select>  
                                            </td>
                                            <td style="border-top: none;">
                                            <input class="form-control" type="number" name="jumlah[]" required>                                    
                                            </td>
                                            <td style="border-top: none;" class="text-center"><a class="removeitem" href="#"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </table>

                                    </div>
                    <button type="submit" class="btn btn-outline-success btn-block">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@push('myjs')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<script>
    $(function() {
  $(".calculate-rows").keyup(function(event) {
    calculate();
  });
});

function calculate() {
    var total = 0;
    $(".calculate-rows").each(function() {
      var gtotal = 0;
      $(this).find(".rows").each(function() {
        var qty = parseFloat($(this).find(".quantity").val());
        var rate = parseFloat($(this).find(".unit-price").val());
          if (isNaN(qty) ) qty = 0;             
          if (isNaN(rate) ) rate = 0;

        var subtotal = qty * rate;
        $(this).find(".total-price").val(subtotal);
        if (!isNaN(subtotal))
          gtotal += subtotal;
          var grantot = gtotal;
        $(".subtotal").val(grantot);
        var discount = $('.discount').val();
        var discount = ((gtotal / 100) * discount);
        var buy = $('.buy').val();
        var total = (gtotal + discount);
        if (!isNaN(total))
          $(".bigtotal").val(total);
          var sisa = (buy - total);
        if(!isNaN(sisa))
            $(".sisa").val(sisa);
      });
    });
}

var wrapper = $('#addrow');
var newitem = $('.newitem');
var removeitem = $('.removeitem');
$(newitem).click(function(e) {
  e.preventDefault();
  $newrow = $('<tr class="rows"><td style="border-top: none;"><select name="id[]" class="form-control"><option value="" disabled selected>--Pilih Produk--</option>@foreach($bahanbaku as $bah)<option value="{{$bah->id}}">{{$bah->nama_barang}} {{$bah->berat}} {{$bah->nama_satuan}}</option>@endforeach</select></td><td style="border-top: none;"><input class="form-control" type="number" name="jumlah[]" required></td><td style="border-top: none;" class="text-center"><a class="removeitem" href="#"><i class="fa fa-times"></i></a></td></tr>');
  $(wrapper).append($newrow);
  $newrow.on("click", "a", function(e) {
    e.preventDefault();
    $(this).parent().parent().remove();
      calculate();
  });
});
$(removeitem).click(function(e) {
  e.preventDefault();
  $(this).parent().parent().remove();
    calculate();
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