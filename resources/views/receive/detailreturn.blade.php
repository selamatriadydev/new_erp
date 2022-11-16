@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> DETAIL BARANG RETURN</h4>
              </div>
              <div class="card-body">
                            <div class="btn-group">
                                <a href="{{route('datareturnsuppliers')}}" class="btn btn-success">Kembali</a>
                            </div>
              </div>
              <div class="card-body">
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <!-- <th>No Return</th>
                        <th>No Invoice</th> -->
                        <th>Nama_item</th>
                        <th>Berat</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($tampil as $purch)
                    <tr>
                    <td>{{$loop->iteration}}</td>
                    <!-- <td>{{$purch->no_return}}</td>
                    <td>{{$purch->no_invoices}}</td> -->
                    <td>{{$purch->nama_barang}}</td>
                    <td>{{$purch->berat}} {{$purch->nama_satuan}}</td>
                    <td>{{$purch->quantity}}</td>
                    <td>@currency($purch->unit_price)</td>
                    <td>@currency($purch->total_price)</td>
                    <td>{{$purch->status}}</td>
                    </tr>
                   @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="2">ppn</th>
                    <th>{{$tax}}%</th>
                    <th colspan="2">total</th>
                    <th>@currency($big)</th>
                    <th></th>               
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
