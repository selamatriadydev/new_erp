@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Master Gudang</h4>
              </div>
              
              <div class="card-body">
                            <div class="btn-group">
                                <a href="{{route('create')}}" class="btn btn-success">create</a>
                            </div>
                    
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>Code Barang</th>
                        <th>Nama Bahanbaku</th>
                        <th>Harga Pokok</th>
                        <th>Berat</th>
                        <th>Stok</th>
                        <th>Harga Jual</th>
                        <th>Pokok Total Harga</th>
                        <th>Jual Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
               @foreach($master as $masters)
               <tr>
                   <td>{{$loop->iteration}}</td>
                   <td>{{$masters->code_master}}</td>
                   <td>{{$masters->nama_barang}} {{$masters->nama_satuan}}</td>
                   <td>@currency($masters->harga_pokok)</td>
                   <td>{{number_format($masters->berat)}} {{$masters->nama_satuan}}</td>
                   <td>{{$masters->stok}}</td>
                   <td>@currency($masters->harga_jual)</td>
                   <td>@currency($masters->sub_total_pokok)</td>
                   <td>@currency($masters->sub_total_jual)</td>
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
