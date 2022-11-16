@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> INVENTORY EGGWAREHOUSE</h4>
              </div>
              
              <div class="card-body">
              <div class="btn-group">
                                <a href="{{route('purchase.egg')}}" class="btn btn-success">create purchase</a>
                            </div>     
                    <div class="dropdown">
                    <button class="btn btn-Secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <br>
                    <br>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="{{route('bigwarehouse')}}">Big Warehouse</a>
                      <a class="dropdown-item" href="{{route('premixwarehouse')}}">Premix warehouse</a>
                      <!-- <a class="dropdown-item" href="{{route('eggwarehouse')}}">Egg Warehouse</a> -->
                      <!-- <a class="dropdown-item" href="{{route('gudangcabang.index')}}">Gudang Cabang</a> -->
                    </div>
                </div>
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Bahanbaku</th>
                        <th>Harga</th>
                        <!-- <th>Berat</th> -->
                        <th>Stok</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($gudang as $gud)
                    <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$gud->nama_barang}} {{$gud->berat}} {{$gud->nama_satuan}}</td>
                    <td>@currency($gud->harga_jual)</td>
                    <!-- <td>{{$gud->berat}} {{$gud->nama_satuan}}</td> -->
                    @if($gud->stok < 3)
                    <td><strong> Stok Tidak Tersedia</strong> </td>
                    @else
                    <td>{{number_format($gud->stok)}} </td>
                    @endif
                    <td>@currency($gud->sub_total_jual)</td>
                     <td>
                    <div class="btn-group">
                        <a href="{{route('gudang.edit',$gud->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        </div>
                        <div class="btn-group">
                        <form action="{{route('gudang.destroy',$gud->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                        </div>
                    </td>
                    </tr>
                    
                   @endforeach
                </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="3"> Total</td>
                      <td>{{number_format($stok)}}</td>
                      <td>@currency($sub)</td>
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
