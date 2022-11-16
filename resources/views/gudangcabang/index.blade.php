@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> INVENTORY GUDANG CABANG</h4>
              </div>
              
              <div class="card-body">
              <div class="btn-group">
                  <a href="{{route('formprod')}}" class="btn btn-success">Transaksi Prod</a>
              </div>
              <div class="btn-group">
                  <a href="{{route('gudangcabang.create')}}" class="btn btn-success">create</a>
              </div>
                            <!-- <div class="btn-group">
                                <a href="{{route('gudang.create')}}" class="btn btn-success">create</a>
                            </div>
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

                            @endif -->
                <!--<div class="row mb-3">-->
                <!--    <div class="col-md-6">-->
                <!--        <form action="{{ route('filter') }}" method="GET" style="display: flex;">-->
                <!--            <select name="pilih" class="form-control" style="height: 33px; margin-top: 8px;">-->
                <!--              <option value="" disabled selected>--Pilih Cabang--</option>-->
                <!--                  @foreach($pilih as $cab)-->
                <!--                      <option value="{{$cab->id}}">{{$cab->nama_cabang}}</option>-->
                <!--                  @endforeach-->
                <!--            </select>-->
                <!--            <input type="submit" class="btn btn-danger btn-sm" value="Filter">-->
                <!--        </form>-->
                <!--    </div>-->
                <!--    <div class="col-md-6">-->
                <!--        <form action="{{ route('pinjam') }}" method="GET" style="display: flex;" >-->
                <!--            <select name="pilih" class="form-control" style="height: 33px; margin-top: 8px;">-->
                <!--            <option value="" disabled selected>--Pilih Cabang--</option>-->
                <!--                @foreach($pilih as $cab)-->
                <!--                    <option value="{{$cab->id}}">{{$cab->nama_cabang}}</option>-->
                <!--                @endforeach-->
                <!--            </select>-->
                <!--            <input type="submit" class="btn btn-danger btn-sm" value="Pinjam">-->
                <!--        </form>-->
                <!--    </div>-->
                <!--</div>-->
                            
                            

                  
                <div class="table-responsive m-t-20">
                <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class=" text-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Bahanbaku</th>
                        <th>Harga</th>
                        <!-- <th>Berat</th> -->
                        <th>Stok</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
               @foreach($gudangcabang as $gudcab)
               <tr>
                 <td>{{$loop->iteration}}</td>
                 <td>{{$gudcab->nama_barang}} {{$gudcab->berat}} {{$gudcab->nama_satuan}}</td>
                 <td>@currency($gudcab->harga_jual)</td>
                 <!-- <td>{{number_format($gudcab->berat)}} </td> -->
                 <td>{{number_format($gudcab->stok)}}</td>
                 <td>@currency($gudcab->harga_jual * $gudcab->stok)</td>
                 <td>
                        <div class="btn-group">
                            <a href="{{route('edit',$gudcab->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        </div>
                        <div class="btn-group">
                        <form action="{{route('destroy',$gudcab->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                        </div>
                 </td>
               </tr>
               @endforeach
                </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="4">total</td>
                      <td>@currency($big_total)</td>
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
