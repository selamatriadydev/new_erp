@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> INVENTORY RETAIL</h4>
              </div>
              
              <div class="card-body">
              <div class="btn-group">
                  <a href="{{route('retail.create')}}" class="btn btn-success">create</a>
              </div>
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Harga Modal</th>
                        <th>harga Jual</th>
                        <th>Stok</th>
                        <th>Sub Modal</th>
                        <th>Sub Jual</th>
                        <th>Images</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($retail as $st)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$st->nama_item}}</td>
                        <td>@currency($st->harga_pk)</td>
                        <td>@currency($st->harga_up)</td>
                        <td>{{number_format($st->stok)}}</td>
                        <td>@currency($st->subtotal_pk)</td>
                        <td>@currency($st->subtotal_up)</td>
                        <td><img style="width:50%;" class="rounded-circle shadow" src="{{asset('images/'.$st->gambar)}}" alt=""></td>
                        <td><a href="" class="x" style="color: green;" data-toggle="modal" data-target="#exampleModal23<?php echo $st->id?>"><i class="fas fa-edit">restok</i></a>
                      
                      <a href="" class="x" style="color: red;" data-toggle="modal" data-target="#exampleModal24<?php echo $st->id?>"><i class="fas fa-edit">return</i></a>
                      <a href="" class="x" style="color: blue;" data-toggle="modal" data-target="#exampleModal25<?php echo $st->id?>"><i class="fas fa-edit">Bonus</i></a>
                    </td>
                    </tr>
                    <div class="modal fade" id="exampleModal23<?php echo $st->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Reminder</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('retail.restokretail')}}" method="post">
                                        @csrf
                                            <input type="hidden" class="form-control" name="id" value="{{$st->id}}" placeholder="Qty" id="">
                                            <input type="hidden" class="form-control" name="code_item" value="{{$st->code_item}}" placeholder="Qty" id="">
                                            <input type="hidden" class="form-control" name="stok" value="{{$st->stok}}" placeholder="Qty" id="">
                                            <input type="hidden" class="form-control" name="hargapk" value="{{$st->harga_pk}}" placeholder="Qty" id="">
                                            <input type="hidden" class="form-control" name="hargaup" value="{{$st->harga_up}}" placeholder="Qty" id="">
                                            <input type="number" class="form-control" name="jumlah" value="" placeholder="Qty" id="">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" style="width : 100%; font-family: hi" class="btn btn-danger">Yes</button>
                                        </form>
                                      </div>
                                </div>
                                </div>
                            </div>
                            <!-- batas return -->
                            <div class="modal fade" id="exampleModal24<?php echo $st->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Return</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('retail.returnretail')}}" method="post">
                                        @csrf
                                            <input type="hidden" class="form-control" name="id" value="{{$st->id}}" placeholder="Qty" id="">
                                            <input type="text" class="form-control" name="code_item" value="{{$st->code_item}}" placeholder="Qty" id="">
                                            
                                            <input type="hidden" class="form-control" name="id_item" value="{{$st->id_item}}" placeholder="Qty" id="">
                                            <input type="hidden" class="form-control" name="harga_pk" value="{{$st->harga_pk}}" placeholder="Qty" id="">
                                            <input type="hidden" class="form-control" name="margin" value="{{$st->margin}}" placeholder="Qty" id="">
                                            <input type="hidden" class="form-control" name="harga_up" value="{{$st->harga_up}}" placeholder="Qty" id="">
                                            <input type="number" class="form-control" name="jumlah" value="" placeholder="Qty" id="">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" style="width : 100%; font-family: hi" class="btn btn-danger">Yes</button>
                                        </form>
                                      </div>
                                </div>
                                </div>
                            </div>
                            <!-- batas bonus -->
                            <div class="modal fade" id="exampleModal25<?php echo $st->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Bonus</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('retail.bonusretail')}}" method="post">
                                        @csrf
                                            <input type="hidden" class="form-control" name="id" value="{{$st->id}}" placeholder="Qty" id="">
                                            <input type="text" class="form-control" name="code_item" value="{{$st->code_item}}" placeholder="Qty" id="">
                                            
                                            <input type="hidden" class="form-control" name="id_item" value="{{$st->id_item}}" placeholder="Qty" id="">
                                            <input type="hidden" class="form-control" name="harga_pk" value="{{$st->harga_pk}}" placeholder="Qty" id="">
                                            <input type="hidden" class="form-control" name="margin" value="{{$st->margin}}" placeholder="Qty" id="">
                                            <input type="hidden" class="form-control" name="harga_up" value="{{$st->harga_up}}" placeholder="Qty" id="">
                                            <input type="number" class="form-control" name="jumlah" value="" placeholder="Qty" id="">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" style="width : 100%; font-family: hi" class="btn btn-danger">Yes</button>
                                        </form>
                                      </div>
                                </div>
                                </div>
                            </div>
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
