@extends('layouts/master')
@section('content')
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> INVENTORY GUDANG</h4>
                            </div>
                                <div class="card-body">
                                        <div class="row">
                                        <div class="table-responsive m-t-40">
                                            <table id="table" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Barang</th>
                                                        <th>harga</th>
                                                        <th>Stok</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($barang as $barangs)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$barangs->nama_barang}} {{$barangs->nama_satuan}}</td>
                                                        <td>@currency($barangs->harga_up)</td>
                                                        <td>{{floor($barangs->stok)}} {{$barangs->nama_satuan}}</td>
                                                        <td><a href=""   data-toggle="modal" data-target="#exampleModal1<?php echo $barangs->id?>">Add</a></td>
                                                    </tr>
                                                    <div class="modal fade" id="exampleModal1<?php echo $barangs->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content" style="background-color: rgba(0, 0, 0, 0.39);">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Qty</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{route('add')}}" method="post">
                                                            @csrf
                                                                <input type="hidden" class="form-control" name="id_barang" value="{{$barangs->id}}" placeholder="Qty" id="">
                                                                <input type="hidden" class="form-control" name="harga_pk" value="{{$barangs->harga_pk}}" placeholder="harga" id="">

                                                                <input type="hidden" class="form-control" name="harga_up" value="{{$barangs->harga_up}}" placeholder="harga" id="">

                                                                <input type="number" class="form-control" name="qty" placeholder="Qty" id="">
                                                                <br>
                                                                <input type="number" class="form-control" name="diskon" placeholder="Discount" id="">
                                                                <br>
                                                                <input type="number" class="form-control" name="cutsale" placeholder="Cut" id="">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            </div>
                                            </div>
                                </div>
                            </div>
                        </div>   
                 </div>
                 
           
       
            </div>
            <div class="col-lg-6" >
            <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">CART</h4>
                                <strong>{{$kode}}</strong>
                                
                            </div>
                                <div class="card-body">
                                        <div class="row">
                                        
                                        <div class="table-responsive m-t-40">
                                            <table id="table" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Barang</th>
                                                        <th>harga</th>
                                                        <th>Qty</th>
                                                        <th>Total</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($cart as $carts)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$carts->nama_barang}}</td>
                                                        <td>@currency($carts->harga_up)</td>
                                                        <td>{{number_format($carts->qty)}} {{$carts->nama_satuan}}</td>
                                                        <td>@currency($carts->sub_total)</td>
                                                        <td> <a href=""   data-toggle="modal" data-target="#exampleModal2<?php echo $carts->id?>">Del</a>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="exampleModal2<?php echo $carts->id?>" tabindex="-1" aria-labelledby="exampleModalLabels" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content" style="background-color: rgba(0, 0, 0, 0.39);">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Reminder</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{route('hapusgudang')}}" method="post">
                                                            @csrf
                                                                <h5 class="modal-title text-white" id="exampleModalLabels">Yakin Anda Akan menghapus {{$carts->nama_barang}}?</h5>
                                                                <input type="hidden" class="form-control" name="hapus_id" value="{{$carts->id}}" placeholder="Qty" id="">
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Yes</button>
                                                            </form>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5">Big Total</td>
                                                        <td>@currency($big_total)</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br>
                                            <form action="{{route('proses')}}" method="POST" enctype="multipart/form-data">
                                             @csrf
                                             <input type="hidden" name="no_invoice" value="{{$kode}}" placeholder="Enter subject" class="form-control" readonly />
                                            <input type="text" name="bayar" value="" placeholder="Enter subject" class="form-control" required/>
                                            <button type="submit" class="btn btn-outline-success btn-block">Save</button>
                                            </form>
                                            
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                </div>
                            </div>
                        </div>   
                    
                </div> 
                         
                

            </div>
     
    </div>
</div>
@push('myjs')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<!-- <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var auto_refresh = setInterval(
    function () {
       $('#load_content').load('show.php').fadeIn("slow");
    }, 10000); // refresh setiap 10000 milliseconds
    
</script>
<script>
 
    $(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            
        ]
    } );
} );
</script>
<!-- <script>
  $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script> -->
@endpush
@endsection