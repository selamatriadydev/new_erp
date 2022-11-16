@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> LIST RECEIVING</h4>
              </div>
              
              <div class="card-body">
                            <div class="btn-group">
                                <a href="{{route('receive.create')}}" class="btn btn-success">create</a>
                            </div>
                            <div class="btn-group">
                                <a href="{{route('datareturnsuppliers')}}" class="btn btn-success">return</a>
                            </div>
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>No Receive</th>
                        <th>No Invoice</th>
                        <th>Supplier</th>
                        <th>Status Bayar</th>
                        <th>Big Total</th>
                        <th>Terbayar</th>
                        <th>Sisa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($receive as $datas)
                    <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$datas->no_receive}}</td>
                    <td>{{$datas->no_invoices}}</td>
                    <td>{{$datas->nama_supplier}}</td>
                    <td></td>
                    <td>@currency($datas->big_totals)</td>
                    <td>@currency($datas->terbayar)</td>
                    <td>@currency($datas->sisa)</td>
                    <td>
                    <div class="btn-group">
                            <a href="{{route('printrec',$datas->id)}}" class="btn btn-success">Print</i></a>
                        </div>
                      <div class="btn-group">
                            <a href="{{route('cek',$datas->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        </div>
                        <div class="btn-group">
                            <a href="{{route('detailbayarbarang',$datas->id)}}" class="btn btn-success">Detail Bayar</a>
                        </div>
                        <div class="btn-group">
                            <a href="{{route('receivebayar',(['id'=>$datas->id]))}}" class="btn btn-success">bayar</a>
                        </div>
                    </td>                    
                    </tr>
                   @endforeach
                </tbody>
                  <tfoot>
                    <tr>
                      <td  colspan="5">Total</td>
                      <td>@currency($sum1)</td>
                      <td>@currency($sum2)</td>
                      <td>@currency($sum3)</td>
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
<!-- <script>
  $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script> -->

@endpush          
@endsection
