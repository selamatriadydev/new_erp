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
                            <div class="btn-group">
                                <a href="{{route('gudangcabang.index')}}" class="btn btn-success">Back</a>
                            </div>
                            <div class="btn-group">
                                <a href="{{route('formprod')}}" class="btn btn-success">create</a>
                            </div>
                           
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>No Purchase</th>
                        <th>Jatuh Tempo</th>
                        <th>Gudang</th>
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
                    <td>{{$datas->nama_gudang}}</td>
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
                            <a href="{{route('detailprod',$datas->id)}}" class="btn btn-success">Detail</a>
                        </div>
                        <div class="btn-group">
                            <a href="{{route('detailbayarprod',$datas->id)}}" class="btn btn-success">Detail Pay</a>
                        </div>
                        <div class="btn-group">
                            <a href="{{route('bayarprod',$datas->id)}}" class="btn btn-success">Pay</a>
                        </div>
                        <div class="btn-group">
                            <a href="{{route('printprod',$datas->id)}}" class="btn btn-success">Print</a>
                        </div>
                       

                        
                    </td>
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
