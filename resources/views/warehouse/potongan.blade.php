@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">DATA POTONGAN BARANG</h4>
              </div>
              
              <div class="card-body">
                           
              <div class="btn-group">
                                <a href="{{route('form_potongan')}}" class="btn btn-success">create</a>
                            </div>
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>Code Barang</th>
                        <th>Nama Barang</th>
                        <!--<th>Harga Pokok</th>-->
                        <!--<th>Berat</th>-->
                        <th>Range 1</th>
                        <th>Range 2</th>
                        <th>Potongan</th>
                        <!--<th>Pokok Total Harga</th>-->
                        <!--<th>Jual Total Harga</th>-->
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($potongan as $pot)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$pot->code_master}}</td>
                        <td>{{$pot->nama_barang}} {{$pot->nama_satuan}}</td>
                        <td>{{$pot->range1}}</td>
                        <td>{{$pot->range2}}</td>
                        <td>@currency($pot->potongan)</td>
                        <td></td>
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
