@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> LIST PURCHASE</h4>
              </div>
              
              <div class="card-body">
                @if(Auth::user()->hak_akses == "Admin Gudangcabang" || Auth::user()->hak_akses == "Admin Bigwarehouse")
                            <div class="btn-group">
                                <a href="{{route('createbig')}}" class="btn btn-success">create</a>
                            </div>
                @elseif(Auth::user()->hak_akses == "Admin Eggwarehouse")
                            <div class="btn-group">
                                <a href="{{route('purchase.egg')}}" class="btn btn-success">create</a>
                            </div>
            
                @endif      
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>No Purchase</th>
                        <th>Jatuh Tempo</th>
                        <th>Purchaser</th>
                        <th>Big Total</th>
                        <th>Terbayar</th>
                        <th>Sisa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($data as $datas)
                    <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$datas->no_purchase}}</td>
                    <td>{{ \Carbon\Carbon::parse($datas->due_date)->format('D ,d M Y')}}</td>
                    <td>{{$datas->name}}</td>
                    <td>@currency($datas->big_total)</td>
                    <td>@currency($datas->bayar)</td>
                    <td>@currency($datas->sisa)</td>
                    <td>
                            @if($datas->big_total == 0)
                            <p>Belum ada Tagihan</p>
                            @elseif($datas->bayar >= $datas->big_total )
                            <p>Lunas</p>
                            @elseif($datas->bayar == 0 )
                            <p>Belum Bayar</p>
                            @elseif($datas->bayar < $datas->big_total)
                            <p>Belum Lunas</p>
                            @endif
                    </td>
                    <td>
                    <div class="btn-group">
                            <a href="{{route('printpur',$datas->id)}}" class="btn btn-success">Print</a>
                        </div>
                    <div class="btn-group">
                            <a href="{{route('lihatin',$datas->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        </div>
                        <div class="btn-group">
                            <a href="{{route('detailbayarin',$datas->id)}}" class="btn btn-success">Detail Bayar</a>
                        </div>
                        @if(Auth::user()->hak_akses == 'Admin Financewarehouse')
                        <div class="btn-group">
                            <a href="{{route('bayar',(['id'=>$datas->id]))}}" class="btn btn-success">bayar</a>
                        </div>
                        @endif

                    </td>
                    </tr>
                   @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="6">Total Sisa Tagihan</th>
                    <th>@currency($sum)</th>
                    <th colspan="2"></th>
                    
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
