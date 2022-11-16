@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> DETAIL BAYAR</h4>
              </div>
              <div class="card-body">
                            <div class="btn-group">
                                <a href="{{route('receive.index')}}" class="btn btn-success">Kembali</a>
                            </div>
              </div>
              <div class="card-body">
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>No Receive</th>
                        <th>Bayar</th>
                        <th>Waktu Bayar</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($tampil as $purch)
                    <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$purch->no_receive}}</td>
                    <td>@currency($purch->nominal)</td>
                    <td>{{$purch->created_at}}</td>
                    </tr>
                   @endforeach
                </tbody>
                 <tfoot>
                  @foreach($tot as $datas)
                <tr>
                    <th colspan="2">total terbayar</th>
                    <th>@currency($datas->terbayar)</th>
                    <th>Sisa @currency($datas->sisa)</th>
                                    
                </tr>
                @endforeach
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
