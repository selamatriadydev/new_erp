@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">DATA PEMINJAMAN ANTAR CABANG</h4>
              </div>
              
              <div class="card-body">
                            <!-- <div class="btn-group">
                                <a href="{{route('purchase.create')}}" class="btn btn-success">create</a>
                            </div>
                            -->
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>No Peminjaman</th>
                        <th>Jatuh Tempo</th>
                        <th>Peminjam</th>
                        <th>Big Total</th>
                        <th>Terbayar</th>
                        <th>Sisa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tampil as $tam)
                <tr> 
                    <td>{{$loop->iteration}}</td>
                    <td>{{$tam->no_peminjaman}}</td>
                    <td>{{ \Carbon\Carbon::parse($tam->due_date)->format('D ,d M Y')}}</td>
                    <td>{{$tam->nama_cabang}}</td>
                    <td>@currency($tam->big_total)</td>
                    <td>@currency($tam->bayar)</td>
                    <td>@currency($tam->sisa)</td>
                    <td>{{$tam->status}}</td>
                    <td>
                    <div class="btn-group">
                            <a href="{{route('detailpeminjaman',$tam->id)}}" class="btn btn-success">Detail</a>
                        </div>
                        <div class="btn-group">
                            <a href="{{route('detailbayarhutang',$tam->id)}}" class="btn btn-success">Detail Hutang</a>
                        </div>
                        <div class="btn-group">
                            <a href="{{route('formbayar',$tam->id)}}" class="btn btn-success">bayar</a>
                        </div>
                        <div class="btn-group">
                            <a href="{{route('printpin',$tam->id)}}" class="btn btn-success">print</a>
                        </div>
                    </td>
                   
              
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th colspan="4">Total</th>
                  <th>@currency($sum)</th>
                  <th>@currency($bayar)</th>
                  <th>@currency($sisa)</th>
                  <th colspan="2"></th>
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
