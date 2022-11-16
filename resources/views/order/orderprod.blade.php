@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> DATA ORDER</h4>
              </div>
               <div class="card">
            <div class="card-body">
                <div class="dropdown">
                     
                  <form action="{{route('filterdataproduksi')}}" method="get">
                                        <div class="row input-daterange">
                                            
                                            <div class="col-md-3">
                                                <input type="text" name="datetimes" class="form-control"/>
                                            </div>
                                            <div class="col-md-3">
                                            <button class="btn btn-secondary" type="submit">Filter Kirim</button>
                                            </div>
                                            <div class="col-md-2">
                                            <a href="{{route('dataprod')}}" class="btn btn-green d-none d-lg-block m-l-15"><i class="fas fa-arrow-alt-circle-left"></i>Dadakan</a>
                                            </div>
                                        </div>
                                    </form>
                                    <form action="{{route('filterdatamasukproduksi')}}" method="get">
                                        <div class="row input-daterange">
                                            
                                            <div class="col-md-3">
                                                <input type="text" name="datetimes" class="form-control"/>
                                            </div>
                                            <div class="col-md-3">
                                            <button class="btn btn-secondary" type="submit">Filter Masuk</button>
                                            </div>
                                            <!--<div class="col-md-2">-->
                                            <!--<a href="{{route('dataorder')}}" class="btn btn-green d-none d-lg-block m-l-15"><i class="fas fa-arrow-alt-circle-left"></i>All</a>-->
                                            <!--</div>-->
                                        </div>
                                    </form>
                    <div class="col-md-5">
                        <br>
                </div>
              </div>
              </div>
              <div class="card-body"> 
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>Invoice</th>
                        <th>Paket</th>
                        <th>Qty</th>
                        <th>Pengiriman</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($order as $orders)
                    <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$orders->no_invoice}}</td>
                    <td>{{$orders->nama_paket}}</td>
                    <td>{{$orders->qty}}</td>
                    <td>{{ \Carbon\Carbon::parse($orders->tanggal_kirim)->isoFormat('dddd, D MMMM Y')}} ,{{ \Carbon\Carbon::parse($orders->jam_kirim)->format('H:i')}}</td>
                    <td>{{$orders->status}}</td>
                    <td>
                        @if($orders->status == "Masuk")
                    <div class="btn-group">
                              <a href="" style="width : 100%; font-family: hi" class="btn btn-success" data-toggle="modal" data-target="#exampleModal3<?php echo $orders->id?>">Produksi
                              </a>
                        </div>
                        @endif
                        @if($orders->status == "Sedang diproduksi")
                        <div class="btn-group">
                              <a href="" style="width : 100%; font-family: hi" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal1<?php echo $orders->id?>">Selesai
                              </a>
                        </div>
                        @endif
                    </td>
                    </tr>
                    <div class="modal fade" id="exampleModal3<?php echo $orders->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Are you Ready?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('produksi')}}" method="post">
                                        @csrf
                                            <input type="hidden" class="form-control" name="invoice" value="{{$orders->no_invoice}}" placeholder="Qty" id="">
                                            <p class="cart text-center">Apakah Anda siap memproduksi {{$orders->nama_paket}} sekarang?</p>     
                                            <p class="cart text-center">dengan jumlah  {{$orders->qty}}</p>                                         
                                            <input type="hidden" class="form-control" name="id_paket" value="{{$orders->id_paket}}" placeholder="Qty" id="">
                                            <input type="hidden" class="form-control" name="qty" value="{{$orders->qty}}" placeholder="Qty" id="">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" style="width : 100%; font-family: hi" class="btn btn-danger">Yes</button>
                                        </form>
                                      </div>
                                </div>
                                </div>
                            </div>

                            <!-- selesai -->
                            <div class="modal fade" id="exampleModal1<?php echo $orders->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Are you Finished?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('selesai')}}" method="post">
                                        @csrf
                                            <input type="hidden" class="form-control" name="invoice" value="{{$orders->no_invoice}}" placeholder="Qty" id="">
                                            <p class="cart text-center">Apakah Anda sudah selesai memproduksi {{$orders->nama_paket}}?</p>     
                                            <p class="cart text-center">dengan jumlah  {{$orders->qty}}</p>                                         
                                            <input type="hidden" class="form-control" name="id_paket" value="{{$orders->id_paket}}" placeholder="Qty" id="">
                                            <input type="hidden" class="form-control" name="qty" value="{{$orders->qty}}" placeholder="Qty" id="">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" style="width : 100%; font-family: hi" class="btn btn-danger">Yes</button>
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
@push('myjs')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> -->
<script>
    $(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
<script>
            $(document).ready(function () {
                $(".odate").datepicker({
                    showOn: "button",
                    buttonImage: "/crudv22/public/overcast/images/calendar19.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd",
                    changeMonth: true,
                    changeYear: true
                });
            });
</script>   
<script>
$(function() {
  $('input[name="datetimes"]').daterangepicker({
    timePicker: true,
    startDate: moment().startOf('hour'),
    endDate: moment().startOf('hour').add(32, 'hour'),
    locale: {
      format: 'YYYY/MM/DD'
    }
  });
});
</script>
@endpush          
@endsection
