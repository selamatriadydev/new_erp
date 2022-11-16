@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> PAKET</h4>
              </div>
              @if(session('pesan'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>{{session('pesan')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
              <div class="card-body">
                            <div class="btn-group">
                                <a href="{{route('paket.create')}}" class="btn btn-success">create</a>
                            </div>
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>jenis Paket</th>
                        <th>Hpp</th>
                        <th>Harga Jual</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($paket as $pakets)
                    <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$pakets->nama_paket}}</td>
                    <td>{{$pakets->jenis_paket}}</td>
                    <td>@currency($pakets->hpp)</td>
                    <td>@currency($pakets->harga_jual)</td>
                    <td>
                        <!--<img style="width:50%;" class="rounded-circle shadow" src="{{asset('images/'.$pakets->gambar)}}" alt="">-->
                        </td>
                    <td>
                    <div class="btn-group">
                        <a href="{{route('detailpaket',$pakets->id)}}" class="btn btn-success">Detail</a>
                        </div>
                        <div class="btn-group">
                        <a href="" class="btn btn-warning" style="color: black;" data-toggle="modal" data-target="#exampleModal23<?php echo $pakets->id?>"><i class="fas fa-edit">Edit</i></a>
                        </div>
                        <div class="btn-group">
                        <form action="{{route('paket.destroy',$pakets->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                        </div>
                    </td>
                    </tr>
                     <div class="modal fade" id="exampleModal23<?php echo $pakets->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Anda Yakin mau Ganti?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('paket.ubah')}}" method="post">
                                        @csrf
                                            <input type="hidden" class="form-control" name="code_paket" value="{{$pakets->code_paket}}" placeholder="code Paket" id="">
                                            <input type="text" class="form-control" name="nama_paket" value="{{$pakets->nama_paket}}" placeholder="Nama Paket" id="">
                                            <br>
                                            
                                            <input type="text" class="form-control" name="hpp" value="{{$pakets->hpp}}" placeholder="Harga" id="">
                                            <br>
                                            <input type="text" class="form-control" name="harga_jual" value="{{$pakets->harga_jual}}" placeholder="Harga" id="">
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
 <script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
      alert(msg);
    }
  </script>
<!-- <script>
  $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script> -->

@endpush          
@endsection
