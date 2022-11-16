@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> INVENTORY GUDANG</h4>
              </div>
              
              <div class="card-body">
                            @if(Auth::user()->hak_akses == "Admin Premixwarehouse")
                            <div class="btn-group">
                                <a href="{{route('createpremix')}}" class="btn btn-success">createpremix</a>
                            </div>
                            @else
                            <div class="btn-group">
                                <a href="{{route('gudang.create')}}" class="btn btn-success">create</a>
                            </div>
                            @endif
                            @if(Auth::user()->hak_akses == "Admin Bigwarehouse")
                            <div class="btn-group">
                                <a href="{{route('returnbarang')}}" class="btn btn-success">return</a>
                            </div>
                            @elseif(Auth::user()->hak_akses == "Admin Eggwarehouse")
                            <div class="btn-group">
                                <a href="{{route('returnbarang')}}" class="btn btn-success">return</a>
                            </div>
                            @elseif(Auth::user()->hak_akses == "Admin Premixwarehouse")
                            <div class="btn-group">
                                <a href="{{route('returnbarang')}}" class="btn btn-success">return</a>
                            </div>
                            @else

                            @endif
                    <div class="dropdown">
                    <button class="btn btn-Secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <br>
                    <br>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="{{route('bigwarehouse')}}">Big Warehouse</a>
                      <a class="dropdown-item" href="{{route('premixwarehouse')}}">Premix warehouse</a>
                      <a class="dropdown-item" href="{{route('eggwarehouse')}}">Egg Warehouse</a>
                      <!-- <a class="dropdown-item" href="{{route('gudangcabang.index')}}">Gudang Cabang</a> -->
                    </div>
                </div>
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>Code</th>
                        <th>Barang</th>
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
                    <td>{{$gud->code_barang_model}}</td>
                    <td>{{$gud->nama_barang}} {{$gud->berat}} {{$gud->nama_satuan}}</td>
                    <td>@currency($gud->harga_jual)</td>
                    <!-- <td>{{$gud->berat}} {{$gud->nama_satuan}}</td> -->
                    <td>{{number_format($gud->stok)}}</td>
                    <td>@currency($gud->sub_total_jual)</td>
                     <td>
                       @if($gud->stok < 40 && $gud->nama_gudang == "Admin Premixwarehouse")
                        <div class="btn-group">
                        <a href="" data-toggle="modal" class="btn btn-success" data-target="#exampleModal3<?php echo $gud->id?>">Restok Premix</a>
                        </div>
                      @elseif($gud->stok < 40 && $gud->nama_gudang != "Admin Premixwarehouse")
                        <div class="btn-group">
                        <a href="" data-toggle="modal" class="btn btn-success" data-target="#exampleModal2<?php echo $gud->id?>">Restok</a>
                        </div>
                        @endif
                        
                     
                    <div class="btn-group">
                        <a href="{{route('editbarang',$gud->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        </div>
                        
                        <div class="btn-group">
                        <form action="{{route('gudang.destroy',$gud->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                        </div>
                    </td>
                    <div class="modal fade" id="exampleModal3<?php echo $gud->id?>" tabindex="-1" aria-labelledby="exampleModalLabels" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content" style="background-color: rgba(0, 0, 0, 0.39);">
                    <div class="modal-header">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Restok {{$gud->code_barang_model}} {{$gud->nama_barang}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                    <form action="{{route('restokpremix')}}" method="post">
                    @csrf
                    <h5 class="modal-title text-white" id="exampleModalLabels">{{$gud->nama_barang}}?</h5>
                    <input type="hidden" class="form-control" name="code_barang_model" value="{{$gud->code_barang_model}}" placeholder="Qty" id="">
                    <input type="hidden" class="form-control" name="id" value="{{$gud->id}}" placeholder="Qty" id="">
                    <input type="hidden" class="form-control" name="berat" value="{{$gud->berat}}" placeholder="Qty" id="">
                    <br> 
                    <input type="number" class="form-control text-red" name="stok" value="" placeholder="Qty" id="">
                    <br>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Yes</button>
                    </form>
                    </tr>
                    <!--  -->
                    <div class="modal fade" id="exampleModal2<?php echo $gud->id?>" tabindex="-1" aria-labelledby="exampleModalLabels" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content" style="background-color: rgba(0, 0, 0, 0.39);">
                    <div class="modal-header">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Restok {{$gud->code_barang_model}} {{$gud->nama_barang}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                    <form action="{{route('restokbarang')}}" method="post">
                    @csrf
                    <h5 class="modal-title text-white" id="exampleModalLabels">{{$gud->nama_barang}}?</h5>
                    <input type="hidden" class="form-control" name="code_master" value="{{$gud->code_master}}" placeholder="Qty" id="">
                    <input type="hidden" class="form-control" name="id" value="{{$gud->id}}" placeholder="Qty" id="">
                    <input type="hidden" class="form-control" name="berat" value="{{$gud->berat}}" placeholder="Qty" id="">
                    <br> 
                    <input type="number" class="form-control text-red" name="new_stok" autofocus placeholder="Qty" id="">
                    <br>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Yes</button>
                    </form>
                   @endforeach
                </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="4"> Total</td>
                      <td></td>
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
