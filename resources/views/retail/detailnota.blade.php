@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> DETAIL RETAIL</h4>
              </div>
              
              <div class="card-body">
              <div class="btn-group">
                  <a href="{{route('retail.notapos')}}" class="btn btn-success">kembali</a>
              </div>
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Harga Modal</th>
                        <th>harga Jual</th>
                        <th>Jumlah</th>
                        <th>Disc</th>
                        <th>Cutsale</th>
                        <th>Sub Modal</th>
                        <th>Sub Jual</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detail as $dt)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$dt->nama_item}}</td>
                        <td>@currency($dt->harga_pk)</td>
                        <td>@currency($dt->harga_up)</td>
                        <td>{{number_format($dt->jumlah)}}</td>
                        <td>{{$dt->disc}}%</td>
                        <td>@currency($dt->cut_sale)</td>
                        <td>@currency($dt->subtotal_pk)</td>
                        <td>@currency($dt->subtotal_up)</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7">Total</td>
                        <td>@currency($modal)</td>
                        <td>@currency($profit)</td>
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
