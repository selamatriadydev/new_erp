@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> DATA TRANSAKSI RETAIL</h4>
              </div>
              
              <div class="card-body">
              <div class="btn-group">
                  <a href="{{route('retail.pos')}}" class="btn btn-success">create</a>
              </div>
               <div class="card">
                <div class="card-body">
                <div class="dropdown">
                   
                                    <form action="{{route('filterdatapos')}}" method="get">
                                        <div class="row input-daterange">
                                            
                                            <div class="col-md-3">
                                                <input type="text" name="datetimes" class="form-control"/>
                                            </div>
                                            <div class="col-md-3">
                                            <button class="btn btn-secondary" type="submit">Filter Transaksi</button>
                                            </div>
                                            <div class="col-md-2">
                                            <a href="{{route('retail.notapos')}}" class="btn btn-green d-none d-lg-block m-l-15"><i class="fas fa-arrow-alt-circle-left"></i>All</a>
                                            </div>
                                        </div>
                                    </form>
                    <div class="col-md-5">
                        <br>
                </div>
              </div>
              </div>
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>No Transaksi</th>
                        <th>Tanggal Transaksi</th>
                        <th>Nama Kasir</th>
                        <th>Sub Modal</th>
                        <th>Sub Jual</th>
                        <th>Profit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nota as $notas)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$notas->no_nota}}</td>
                        <td>{{ \Carbon\Carbon::parse($notas->tanggal_transaksi)->format('D ,d M Y')}}</td>
                        <td>{{$notas->name}}</td>
                        <td>@currency($notas->subtotal_pk)</td>
                        <td>@currency($notas->subtotal_up)</td>
                        <td>@currency($notas->subtotal_up - $notas->subtotal_pk)</td>
                        <td><a href="" class="x" style="color: green;" data-toggle="modal" data-target="#exampleModal27<?php echo $notas->id?>">Cek</a></td>
                    </tr>
                    <div class="modal fade" id="exampleModal27<?php echo $notas->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Reminder</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('retail.detailnota')}}" method="post">
                                        @csrf
                                            <input type="hidden" class="form-control" name="no_nota" value="{{$notas->no_nota}}" placeholder="Qty" id="">
                                            <p class="cart text-center">Cek Nota {{$notas->no_nota}} ?</p>
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
                <tfoot>
                    <tr><td colspan="4">Total</td>
                    <td>@currency($pk)</td>
                    <td>@currency($up)</td>
                    <td>@currency($up - $pk)</td>
                    <td></td></tr>
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
@endpush          
@endsection
