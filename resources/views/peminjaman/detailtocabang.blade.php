@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">DETAIL PEMINJAMAN</h4>
              </div>
              
              <div class="card-body">
              <div class="btn-group">
                                <a href="{{route('tocabang')}}" class="btn btn-success">Back</a>
                            </div>     
                           
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Berat</th>
                        <th>Harga</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($isi as $tam)
                <tr> 
                    <td>{{$loop->iteration}}</td>
                    <td>{{$tam->nama_barang}}</td>
                    <td>{{$tam->berat}} {{$tam->nama_satuan}}</td>
                    <td>@currency($tam->harga)</td>
                    <td>{{number_format($tam->quantity)}}</td>
                    <td>@currency($tam->sub_total)</td>
                    <td>{{$tam->status}}</td>
                    <td>
                      @if($tam->status == "ready")
                        <div class="btn-group">
                            <a href="{{ route('tostokpinjam',(['id'=>$tam->id]))}}" class="btn btn-success">to stok</a>
                        </div>
                        @endif  
                    </td>
                </tr>
                <div class="modal fade" id="exampleModal<?php echo $tam->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">{{$tam->no_purchase}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <form action="{{route('aksipinjam',$tam->id)}}" method="POST">
                <div class="form-body">
                @csrf
                @method('patch')
                                <div class="form-group">
                                    <div class="row">

                                        <div class="col-md-6">
                                    
                                            <div class="card-body">
                                                <label for="">QTY old</label>
                                                <input type="text" name="" value="{{$tam->quantity}}" class="form-control" readonly>
                                            </div>
                                
                                        </div>
                                        <div class="col-md-6">
                                    
                                            <div class="card-body">
                                                <label for="">Qty new</label>
                                                <input type="number" name="quantity" value="" class="form-control" >
                                            </div>
                                
                                        </div>
                                    </div>                    
                                </div>
                    <button type="submit" class="btn btn-outline-success btn-block">Save</button>
                </form>
                </div>
                
              </div>
            </div>
          </div>
    
                @endforeach
                </tbody>
                <tfoot>
                
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
