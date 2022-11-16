@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> LIST BARANG RETURN</h4>
              </div>
              
              <div class="card-body">
                            <div class="btn-group">
                                <a href="{{route('gudang.index')}}" class="btn btn-success">back</a>
                            </div>
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>No Purchase</th>
                        <th>Bahanbaku</th>
                        <th>Harga Pokok</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($return as $datas)
                    <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$datas->no_purchase}}</td>
                    <td>{{$datas->nama_barang}}</td>
                    <td>@currency($datas->harga_pk)</td>
                    <td>{{$datas->qty}}</td>
                    <td>@currency($datas->harga_pk * $datas->qty)</td>
                    <td>{{$datas->status}}</td>
                    <td>
                    @if($datas->status == "return")
                        <div class="btn-group">
                            <a href="{{route('restok',$datas->id)}}" class="btn btn-success">Restok</a>
                        </div>
                    @endif
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
