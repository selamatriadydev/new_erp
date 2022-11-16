@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Master Barang</h4>
              </div>
              
              <div class="card-body">
                            <div class="btn-group">
                                <a href="{{route('create')}}" class="btn btn-success">create</a>
                            </div>
                    <!-- <div class="btn-group">
                                <a href="{{route('createpremix')}}" class="btn btn-success">create premix</a>
                            </div> -->
                            
                           <div class="card">
                            <div class="card-body">
                            <div class="dropdown">
                               
                                                <form action="{{route('filterkategori')}}" method="post">
                                                    @csrf
                                                    <div class="row input-daterange">
                                                        
                                                        <div class="col-md-3">
                                                            <select name="filter_id" class="form-control">
                                                                <option value="" disabled selected>--Pilih Kategori--</option>
                                                                @foreach($kategori as $kat)
                                                                    <option value="{{$kat->id}}">{{$kat->kategori}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                        <button class="btn btn-secondary" type="submit">Filter Kategori</button>
                                                        </div>
                                                    </div>
                                                </form>
                                <div class="col-md-5">
                                    <br>
                            </div>
                          </div>
                          </div>
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>Code Barang</th>
                        <th>Nama Bahanbaku</th>
                        <!--<th>Harga Pokok</th>-->
                        <!--<th>Berat</th>-->
                        <th>Stok</th>
                        <th>Harga Jual</th>
                        <!--<th>Pokok Total Harga</th>-->
                        <!--<th>Jual Total Harga</th>-->
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
               @foreach($master as $masters)
               <tr>
                   <td>{{$loop->iteration}}</td>
                   <td>{{$masters->code_master}}</td>
                   <td>{{$masters->nama_barang}} {{$masters->nama_satuan}}</td>
                   <!--<td>@currency($masters->harga_pokok)</td>-->
                   <!--<td>{{number_format($masters->berats)}} {{$masters->nama_satuan}}</td>-->
                   <td>{{number_format($masters->stok)}} </td>
                   <td>@currency($masters->harga_jual)</td>
                   <!--<td>@currency($masters->sub_total_pokok)</td>-->
                   <!--<td>@currency($masters->sub_total_jual)</td>-->
                   <td>
                     <a href="" class="x" style="color: red;" data-toggle="modal" data-target="#exampleModal<?php echo $masters->id?>"><i class="fas fa-edit">Hapus</i></a>
                     @if($masters->stok < 2)
                     <a href="" class="x" style="color: green;" data-toggle="modal" data-target="#exampleModal23<?php echo $masters->id?>"><i class="fas fa-edit">Restok</i></a>
                     @endif
                     <!-- <a href="" class="x" style="color: blue;" data-toggle="modal" data-target="#exampleModal87<?php echo $masters->id?>"><i class="fas fa-edit">Detail</i></a> -->
                     <a href="" class="x" style="color: blue;" data-toggle="modal" data-target="#exampleModal33<?php echo $masters->id?>"><i class="fas fa-edit">Edit</i></a>
                    </td>
                  </tr>
                  <div class="modal fade" id="exampleModal33<?php echo $masters->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Edit</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('editmas')}}" method="post">
                                        @csrf
                                            <input type="hidden" class="form-control" name="code_master" value="{{$masters->code_master}}" placeholder="Qty" id="">
                                            <select name="idkat" class="form-control">
                                                <option value="" disabled selected>--Pilih Kategori--</option>
                                                @foreach($kategori as $kat)
                                                    <option value="{{$kat->id}}">{{$kat->kategori}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" style="width : 100%; font-family: hi" class="btn btn-danger">Yes</button>
                                        </form>
                                      </div>
                                </div>
                                </div>
                            </div>
                  <div class="modal fade" id="exampleModal87<?php echo $masters->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Cek Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('warehouse.detail')}}" method="post">
                                        @csrf
                                            <input type="hidden" class="form-control" name="id" value="{{$masters->id}}" placeholder="Qty" id="">
                                            <input type="hidden" class="form-control" name="code" value="{{$masters->code_master}}" placeholder="Qty" id="">
                                            <!--<input type="number" class="form-control" name="nilai" value="" placeholder="Qty" id="">-->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" style="width : 100%; font-family: hi" class="btn btn-danger">Yes</button>
                                        </form>
                                      </div>
                                </div>
                                </div>
                            </div>
                   <div class="modal fade" id="exampleModal23<?php echo $masters->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Reminder</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('restok.gudang')}}" method="post">
                                        @csrf
                                            <input type="hidden" class="form-control" name="id" value="{{$masters->id}}" placeholder="Qty" id="">
                                            <input type="hidden" class="form-control" name="code_barang_model" value="{{$masters->code_masters}}" placeholder="Qty" id="">
                                            <input type="number" class="form-control" name="nilai" value="" placeholder="Qty" id="">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" style="width : 100%; font-family: hi" class="btn btn-danger">Yes</button>
                                        </form>
                                      </div>
                                </div>
                                </div>
                            </div>
                   <div class="modal fade" id="exampleModal<?php echo $masters->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Warning</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('haps')}}" method="post">
                                        @csrf
                                            <input type="hidden" class="form-control" name="code_masters" value="{{$masters->code_master}}" id="">
                                            <p class="cart text-center">Yakin Ingin Hapus {{$masters->nama_barang}}?</p>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" style="width : 100%; font-family: hi" class="btn btn-danger">Yes</button>
                                        </form>
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
