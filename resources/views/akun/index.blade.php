@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">LIST USER</h4>
              </div>
              
              <div class="card-body">
                            <div class="btn-group">
                                <a href="{{route('akun.create')}}" class="btn btn-success">create</a>
                            </div>
                <div class="table-responsive">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>Action</th>
                        <th>Nama</th>
                        <th>Hak Akses</th>
                        <th>Email</th>
                        <th>Cabang</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach ($user as $item)
                    <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('akun.edit',$item->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        </div>
                        @if($item->userstatus == 'nonaktif')
                        <div class="btn-group">
                            <a href="{{route('akun.aktifuser',$item->id)}}" class="btn btn-warning">Aktif</a>
                        </div>
                        @else
                        <div class="btn-group">
                            <a href="{{route('akun.nonaktifuser',$item->id)}}" class="btn btn-danger">nonaktif</a>
                        </div>
                        @endif
                        <div class="btn-group">
                        <form action="{{route('akun.destroy',$item->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                        </div>
                    </td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->hak_akses}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->nama_cabang}}</td>
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
