@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> LIST KOMPONEN</h4>
              </div>
              
              <div class="card-body">
                            <div class="btn-group">
                                <a href="{{route('komponen.create')}}" class="btn btn-success">create</a>
                            </div>
                           
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Komponen</th>
                        <th>Hpp</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($tampil as $tam)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$tam->nama_komponen}}</td>
                    <td>@currency($tam->total_hpp)</td>
                    <td>@currency($tam->total_harga_jual)</td>
                    <td>
                    <div class="btn-group">
                            <a href="{{route('detailkomponen',$tam->id)}}" class="btn btn-success">Detail</a>
                        </div>
                        <div class="btn-group">
                              <a href="" style="width : 100%; font-family: hi" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal<?php echo $tam->id?>">Hapus
                              </a>
                        </div>
                    </td>
                  </tr>
                   <div class="modal fade" id="exampleModal<?php echo $tam->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Pelunasan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('hapuskomponen')}}" method="post">
                                        @csrf
                                            <input type="hidden" class="form-control" name="code_komponen" value="{{$tam->code_komponen}}" id="">
                                            <p class="cart text-center">Yakin Ingin Hapus {{$tam->nama_komponen}}?</p>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" style="width : 100%; font-family: hi" class="btn btn-danger">Yes</button>
                                        </form>
                                      </div>
                                </div>
                                </d
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
