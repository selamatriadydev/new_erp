@extends('layouts/master')
@section('content')

<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> RECEIVING</h4>
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
                                <a href="{{route('receive.index')}}" class="btn btn-success">kembali</a>
                            </div>
            <form action="{{route('receive.store')}}" method="POST">
                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                    
                                            <div class="card-body">
                                                <label for="">No Receive</label>
                                                <input type="text" name="no_receive" value="{{$kode}}" class="form-control" readonly>
                                            </div>
                                
                                        </div>
                                        <div class="col-md-6">
                                    
                                            <div class="card-body">
                                                <label for="">Receive Date</label>
                                                <input type="date" name="tanggal_terima" value="{{$ldate}}" class="form-control" readonly>
                                            </div>
                                
                                        </div>
                                    </div>                    
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                    
                                            <div class="card-body">
                                                <label for="">No Invoice</label>
                                                <input type="text" name="no_invoices" id="no_invoice" value="" class="form-control">
                                            </div>
                                
                                        </div>
                                        <div class="col-md-6">
                                    
                                            <div class="card-body">
                                                <label for="">Invoice Date</label>
                                                <input type="Date" name="tgl_invoice" id="date" value="" class="form-control">
                                            </div>
                                
                                        </div>
                                    </div>                    
                                </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <label for="">Supplier</label>
                                                <select name="id_supplier" class="form-control" required>
                                                <option value="" >--Pilih Supplier--</option>
                                                @foreach($supplier as $sup)
                                                    <option value="{{$sup->id}}">{{$sup->nama_supplier}}</option>
                                                @endforeach
                                                </select>    
                                            </div>
                                
                                        </div>
                                        <div class="col-md-6">
                                    
                                            <div class="card-body">
                                                <label for="">Due Date</label>
                                                <input type="date" name="due_date" id="no_req" value="" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                       
                                <div class="table-responsive calculate-rows">
                                    <table class="table">
                                        <thead>
                                        <a href="#" class="btn newitem btn-primary tooltip-primary"><i class="fa fa-plus"></i> New Item</a>
                                        <tr>
                                            <th style="width:25%;">Item</th>
                                            <!-- <th style="width:20%;">Berat</th> -->
                                            <!-- <th style="width:21%;">Satuan</th> -->
                                            <th style="width:10%;" class="text-center">Quantity</th>
                                            <th style="width:10%;" class="text-center">Unit Price</th>
                                            <th style="width:10%;" class="text-center">Total Price</th>
                                            <th style="width:4%;"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="addrow">
                                        <tr class="rows">
                                            <td style="border-top: none;">
                                            <select name="id_barang[]" class="form-control">
                                                <option value="" disabled selected>--Pilih Satuan--</option>
                                                @foreach($gudang as $gud)
                                                    <option value="{{$gud->id}}">{{$gud->nama_barang}} {{$gud->nama_satuan}}</option>
                                                @endforeach
                                            </select>
                                            </td>
                                            <!-- <td style="border-top: none;">
                                            <input class="form-control" type="number" name="berat[]" required>                                    
                                            </td> -->
                                            <!-- <td style="border-top: none;">
                                            <select name="id_satuan[]" class="form-control">
                                                <option value="" disabled selected>--Pilih Satuan--</option>
                                                @foreach($satuan as $sat)
                                                    <option value="{{$sat->id}}">{{$sat->nama_satuan}}</option>
                                                @endforeach
                                            </select>                                            
                                            </td> -->
                                            <td style="border-top: none;">
                                            <input class="text-center form-control quantity" type="text" value="" name="quantity[]">
                                            </td>
                                            <td style="border-top: none;">
                                            <input class="text-center form-control unit-price" type="text" value="" name="unit_price[]">
                                            </td>
                                            <td style="border-top: none;">
                                            <input class="form-control text-center total-price" type="text" name="total_price[]" value="0.00" readonly>
                                            </td>
                                            <td style="border-top: none;" class="text-center"><a class="removeitem" href="#"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                       
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="table invoice-table text-right">
                                        <tbody class="totals">
                                        <tr>
                                            <td style="border-top: none;">Sub Total:</td>
                                            <td style="border-top: none;">
                                            <!-- <strong class="subtotal">&#x52;&#x70; 0.00</strong> -->
                                            <input type="text" name="sub_total" class="form-control text-center subtotal"  value="" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border-top: none;">Tax:</td>
                                            <td style="width:20%; border-top: none;">
                                            <div class="fm-group input-group" style="margin-bottom:0px">
                                                <span class="input-group-addon">%</span>
                                                <input type="number" name="tax" class="form-control text-right discount" value="0">
                                            </div>
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                            <td style="border-top: none;">VAT:</td>
                                            <td style="border-top: none;"><strong>&#x52;&#x70; 0</strong>
                                            </td>
                                        </tr> -->
                                        <tr>
                                            <td style="border-top: none;">Amount Due:</td>
                                            <td style="border-top: none;">
                                            <input type="number" name="big_total" class="form-control text-center bigtotal" value="0">
                                            <!-- <strong class="bigtotal">&#x52;&#x70; 0</strong> -->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border-top: none;">Buy/Down Payment</td>
                                            <td style="border-top: none;"><input type="number" name="dp" class="form-control text-right buy" value="0"></td>
                                        </tr>
                                        <tr>
                                            <td style="border-top: none;">Sisa:</td>
                                            <td style="border-top: none;"><input type="number" name="sisa" class="form-control text-center sisa" value="0">
                                            </td>
                                        </tr>
                                        </tbody>
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
          var sisa = (total - buy);
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
  $newrow = $('<tr class="rows"><td style="border-top: none;"><select name="id_barang[]" class="form-control"><option value="" disabled selected>--Pilih bahanbaku--</option>@foreach($gudang as $gud)<option value="{{$gud->id}}">{{$gud->nama_barang}} {{$gud->nama_satuan}}</option>@endforeach</select></td><td style="border-top: none;"><input class="text-center form-control quantity" type="text" value="" name="quantity[]"></td><td style="border-top: none;"><input class="text-center form-control unit-price" type="text" value="" name="unit_price[]"></td><td style="border-top: none;"><input class="form-control text-center total-price" type="text" name="total_price[]" value="0.00" readonly></td><td style="border-top: none;" class="text-center"><a class="removeitem" href="#"><i class="fa fa-times"></i></a></td></tr>');
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
@endpush
@endsection