@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> ITEM</h4>
              </div>
              
              <div class="card-body">
                            <div class="btn-group">
                                <a href="{{route('item.create')}}" class="btn btn-success">create</a>
                            </div>
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>Code Item</th>
                        <th>Nama Item</th>
                        <th>Hpp</th>
                        <th>Harga</th>
                        <th>Resep</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($item as $items)
                    <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$items->code_item}}</td>
                    <td>{{$items->nama_item}}</td>
                    <td>@currency($items->hpp)</td>
                    <td>@currency($items->harga_jual)</td>
                    <td>{{$items->nama_resep}}</td>
                    <td>
                        {{$items->kategori}}
                        </td>
                    <td>
                    <div class="btn-group">
                        <a href="" class="btn btn-warning" style="color: black;" data-toggle="modal" data-target="#exampleModal25<?php echo $items->id?>"><i class="fas fa-edit">Edit</i></a>
                        </div>
                        <div class="btn-group">
                        <a href="{{route('detailitem',$items->id)}}" class="btn btn-success">Detail</a>
                        </div>
                        <div class="btn-group">
                        <form action="{{route('item.destroy',$items->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                        </div>
                    </td>
                    </tr>
                    <div class="modal fade" id="exampleModal25<?php echo $items->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Reminder</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('edit_item')}}" method="post">
                                        @csrf
                                <input type="hidden" name="id" value="{{$items->id}}" placeholder="Masukan Nama" class="form-control" readonly>
                                            <div class="form-group">
                                    <label for="">Code Item</label>
                                <input type="hidden" name="code_item" value="{{$items->code_item}}" placeholder="Masukan Nama" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">item</label>
                                <input type="text" name="nama_item" value="{{$items->nama_item}}" placeholder="Masukan Nama" class="form-control">
                                </div>
                                 <div class="form-group">
                                   <label for="">Hpp</label>
                                <input type="text" name="hpp" value="{{$items->hpp}}" placeholder="Masukan Hpp" class="form-control">
                                </div>
                                <div class="form-group">
                                   <label for="">Harga</label>
                                <input type="text" name="harga_jual" value="{{$items->harga_jual}}" placeholder="Masukan Harga" class="form-control">
                                </div>
                                 <div class="form-group">
                                    <label for="">Resep</label>
                                    <select name="id_resep" class="form-control">
                                                <option value="" disabled selected>--Pilih Resep--</option>
                                                @foreach($resep as $pr)
                                                    <option value="{{$pr->id}}">{{$pr->nama_resep}}</option>
                                                @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Kategori</label>
                                    <select name="id_kategori" class="form-control">
                                                <option value="" disabled selected>--Pilih Kategori--</option>
                                                @foreach($kategori as $pr)
                                                    <option value="{{$pr->id}}">{{$pr->kategori}}</option>
                                                @endforeach
                                    </select>
                                </div>

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
