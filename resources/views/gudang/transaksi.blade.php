@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> LIST TRANSAKSI</h4>
              </div>
              
              <div class="card-body">
                            <div class="btn-group">
                                <a href="{{route('gudang.transak')}}" class="btn btn-success">create</a>
                            </div>
                           
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>No Invoice</th>
                        <th>Big Total</th>
                        <th>Bayar</th>
                        <th>Change</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($invoicing as $invoice)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$invoice->no_invoice}}</td>
                    <td>@currency($invoice->big_total)</td>
                    <td>@currency($invoice->bayar)</td>
                    <td>@currency($invoice->sisa)</td>
                    <td>
                        <div class="btn-group">
                        <a href="{{route('print',$invoice->id)}}" class="btn btn-success">print</a>
                        </div>
                        <div class="btn-group">
                        <a href="{{route('detailgud',$invoice->id)}}" class="btn btn-success">Detail</a>
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
