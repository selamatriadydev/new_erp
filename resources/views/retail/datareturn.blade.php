@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> RETURN RETAIL</h4>
              </div>
              
              <div class="card-body">
              <!-- <div class="btn-group">
                  <a href="{{route('retail.create')}}" class="btn btn-success">create</a>
              </div> -->
              <div class="card">
                <div class="card-body">
                <div class="dropdown">
                   
                                    <form action="{{route('filterdatareturn')}}" method="get">
                                        <div class="row input-daterange">
                                            
                                            <div class="col-md-3">
                                                <input type="text" name="datetimes" class="form-control"/>
                                            </div>
                                            <div class="col-md-3">
                                            <button class="btn btn-secondary" type="submit">Filter Transaksi</button>
                                            </div>
                                            <div class="col-md-2">
                                            <a href="{{route('retail.datareturn')}}" class="btn btn-green d-none d-lg-block m-l-15"><i class="fas fa-arrow-alt-circle-left"></i>All</a>
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
                        <th>Nama Barang</th>
                        <!--<th>Harga Modal</th>-->
                        <th>harga Jual</th>
                        <th>Jumlah</th>
                        <!--<th>Sub Modal</th>-->
                        <th>Sub Jual</th>
                        <!--<th>Images</th>-->
                        <th>Tanggal Return</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach($retail as $st)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$st->nama_item}}</td>
                        <!--<td>@currency($st->harga_pk)</td>-->
                        <td>@currency($st->harga_up)</td>
                        <td>{{number_format($st->qty)}}</td>
                        <!--<td>@currency($st->subtotal_pk)</td>-->
                        <td>@currency($st->subtotal_up)</td>
                        <!--<td><img style="width:50%;" class="rounded-circle shadow" src="{{asset('images/'.$st->gambar)}}" alt=""></td>-->
                        <td>{{ \Carbon\Carbon::parse($st->tanggal_return)->isoFormat('dddd, D MMMM Y')}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total</td>
                        <td>{{number_format($sumqty)}}</td>
                        <!--<td>@currency($sumj)</td>-->
                        <td>@currency($sumt)</td>
                        <!--<td></td>-->
                        <td></td>
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

@endpush          
@endsection
