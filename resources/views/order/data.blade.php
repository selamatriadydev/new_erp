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
                    <form action="{{route('filterdataorder')}}" method="get">
                                        <div class="row input-daterange">
                                            
                                            <div class="col-md-3">
                                                <input type="text" name="datetimes" class="form-control"/>
                                            </div>
                                            <div class="col-md-3">
                                            <button class="btn btn-secondary" type="submit">Filter Masuk</button>
                                            </div>
                                            <div class="col-md-2">
                                            <a href="{{route('dataorder')}}" class="btn btn-green d-none d-lg-block m-l-15"><i class="fas fa-arrow-alt-circle-left"></i>All</a>
                                            </div>
                                        </div>
                                    </form>
                                    <form action="{{route('filterkirimorder')}}" method="get">
                                        <div class="row input-daterange">
                                            
                                            <div class="col-md-3">
                                                <input type="text" name="datetimes" class="form-control"/>
                                            </div>
                                            <div class="col-md-3">
                                            <button class="btn btn-secondary" type="submit">Filter Kirim</button>
                                            </div>
                                            <div class="col-md-2">
                                            <a href="{{route('dataorder')}}" class="btn btn-green d-none d-lg-block m-l-15"><i class="fas fa-arrow-alt-circle-left"></i>All</a>
                                            </div>
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
                        <th>Cust.</th>
                        <th>Pengiriman</th>
                        <th>Tanggal Masuk</th>
                        <th>Big Total</th>
                        <th>Terbayar</th>
                        <th>Sisa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($order as $orders)
                    <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$orders->no_invoice}}</td>
                    <td>{{$orders->nama_cust}}
                        <br>{{$orders->kel}}
                    </td>
                    <td>{{ \Carbon\Carbon::parse($orders->tanggal_kirim)->format('D ,d M Y')}} ,{{ \Carbon\Carbon::parse($orders->jam_kirim)->format('H:i')}}</td>
                    <td>{{ \Carbon\Carbon::parse($orders->tanggal_masuk)->isoFormat('dddd, D MMMM Y')}}</td>
                    <td>@currency($orders->bigtotal)</td>
                    <td>@currency($orders->bayar)</td>
                    <td>@currency($orders->sisa)</td>
                    @if($orders->status == "Cancel")
                    <td><b>{{$orders->status}}</b> karena <br>
                    {{$orders->alasan}}
                    </td>
                    @elseif($orders->sisa < 0)
                    <td><p>Belum Lunas</p>
                    </td>
                    @elseif($orders->sisa = 0)
                    <td>Belum Bayar
                    </td>
                    @else
                    <td><p>Lunas</p>
                    </td>
                    @endif
                      <td>
                      @if($orders->status != "Cancel" && $orders->sisa < 0 )
                      <div class="btn-group">
                              <a href="" style="width : 100%; font-family: hi" class="btn btn-info" data-toggle="modal" data-target="#exampleModal3<?php echo $orders->id?>">Pelunasan
                              </a>
                        </div>
                        @endif
                        <div class="btn-group">
                              <a href="" style="width : 100%; font-family: hi" class="btn btn-success" data-toggle="modal" data-target="#exampleModal1<?php echo $orders->id?>">Print
                              </a>
                        </div>
                       
                        <div class="btn-group">
                              <a href="" style="width : 100%; font-family: hi" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal4<?php echo $orders->id?>">Cancel
                              </a>
                        </div>
                         <div class="btn-group">
                              <a href="" style="width : 100%; font-family: hi" class="btn btn-green" data-toggle="modal" data-target="#exampleModal5<?php echo $orders->id?>">Edit Waktu
                              </a>
                        </div>
                    </td>
                    </tr>
                    <div class="modal fade" id="exampleModal3<?php echo $orders->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Pelunasan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('pelunasanorder')}}" method="post">
                                        @csrf
                                            <input type="hidden" class="form-control" name="invoice" value="{{$orders->no_invoice}}" placeholder="Qty" id="">
                                            <p class="cart text-center">Total Pembayaran  @currency($orders->bayar)</p>     
                                            <p class="cart text-center">Sisa Pembayaran  @currency($orders->sisa)</p>                                         
                                            <input type="number" class="form-control" name="nominal" value="" placeholder="Masukan Nilai Pelunasan" id="">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" style="width : 100%; font-family: hi" class="btn btn-danger">Yes</button>
                                        </form>
                                      </div>
                                </div>
                                </div>
                            </div>
                            <!-- print -->
                            <div class="modal fade" id="exampleModal1<?php echo $orders->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Print</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('printorder')}}" method="post">
                                        @csrf
                                            <input type="hidden" class="form-control" name="invoice" value="{{$orders->no_invoice}}" placeholder="Qty" id="">
                                            <p class="cart text-center">Apa anda akan mencetak {{$orders->no_invoice}} kembali?</p>     
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" style="width : 100%; font-family: hi" class="btn btn-danger">Yes</button>
                                        </form>
                                      </div>
                                </div>
                                </div>
                            </div>
                            <!-- end -->
                            <!-- cancel -->
                            <div class="modal fade" id="exampleModal4<?php echo $orders->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Pelunasan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('cancel')}}" method="post">
                                        @csrf
                                            <input type="hidden" class="form-control" name="invoice" value="{{$orders->no_invoice}}" placeholder="Qty" id="">
                                            <p class="cart text-center">Yakin {{$orders->no_invoice}} akan dicancel?</p>                                         
                                            <input type="text" class="form-control" name="alasan" value="" placeholder="Masukan alasan dengan benar" id="">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" style="width : 100%; font-family: hi" class="btn btn-danger">Yes</button>
                                        </form>
                                      </div>
                                </div>
                                </div>
                            </div>
                            <!-- end -->
                             <!-- edit -->
                            <div class="modal fade" id="exampleModal5<?php echo $orders->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">EDIT WAKTU</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('edittime')}}" method="post">
                                        @csrf
                                            <input type="hidden" class="form-control" name="invoice" value="{{$orders->no_invoice}}" placeholder="Qty" id="">
                                            <p class="cart text-center">Yakin {{$orders->no_invoice}} di Edit?</p>                                         
                                            <input type="date" class="form-control" name="tanggal" value="" placeholder="Masukan alasan dengan benar" id="">
                                            <br>
                                            <input type="time" class="form-control" name="jam" value="" placeholder="Masukan alasan dengan benar" id="">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" style="width : 100%; font-family: hi" class="btn btn-danger">Yes</button>
                                        </form>
                                      </div>
                                </div>
                                </div>
                            </div>
                            <!-- end -->
                   @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">Total</td>
                        <td>@currency($big)</td>
                        <td>@currency($pay)</td>
                        <td>@currency($cha)</td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
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
<!-- <script>
  $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script> -->

@endpush          
@endsection
