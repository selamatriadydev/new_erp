@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> SALES</h4>
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
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Input
                            </button>
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>Code Sales</th>
                        <th>Nama Sales</th>
                        <th>KTP</th>
                        <th>No Hp</th>
                        <th>Button</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($sales as $sale)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$sale->code_sales}}</td>
                  <td>{{$sale->nama_sales}}</td>
                  <td>{{$sale->id_card}}</td>
                  <td>{{$sale->no_hp}}</td>
                  <td></td>
                </tr>
                @endforeach
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Input Sales</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{route('input.sales')}}" method="post">
                                @csrf
                                <div class="modal-body">
                                <input type="text" class="form-control" name="code_sales" value="{{$kode}}" placeholder="Input Sales" id="" readonly >
                                </div>
                                <div class="modal-body">
                                <input type="text" class="form-control" name="id_card" value="" placeholder="Masukan nomor KTP" id="" >
                                </div>
                                <div class="modal-body">
                                <input type="text" class="form-control" name="nama_sales" value="" placeholder="Input Sales" id="" >
                                </div>
                                <div class="modal-body">
                                <input type="text" class="form-control" name="no_hp" value="" placeholder="Input Hp" id="" >
                                </div>
                                <div class="modal-body">
                                <input type="file" class="form-control" name="ktp" value="" placeholder="Input Ktp" id="" >
                                </div>
                                <div class="modal-body">
                                    <textarea name="alamat" placeholder="Alamat" class="form-control form-control-sm" id=""></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                                </div>
                            </div>
                            </form>
                            </div>
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
