@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Customer</h4>
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
                        <th>Code</th>
                        <th>Nama </th>
                        <th>Toko</th>
                        <th>KTP</th>
                        <th>No Hp</th>
                        <th>Sales</th>
                        <th>Tagihan</th>
                        <th>Button</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customerz as $cust)
                    <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$cust->code_customer}}</td>
                    <td>{{$cust->nama}}</td>
                    <td>{{$cust->toko}}</td>
                    <td>{{$cust->no_ktp}}</td>
                    <td>{{$cust->no_hp}}</td>
                    <td>{{$cust->nama_sales}}</td>
                    <td></td>
                    <td></td>
                    </tr>
                    
                    @endforeach
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Input Customer</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{route('input_cust')}}" method="post">
                                @csrf
                                <div class="modal-body">
                                <input type="text" class="form-control" name="code_customer" value="{{$kode}}" placeholder="Input Sales" id="" readonly >
                                </div>
                                                             
                                <div class="modal-body">
                                <input type="text" class="form-control" name="no_ktp" value="" placeholder="Masukan No KTP" id="" >
                                </div>
                                <div class="modal-body">
                                <input type="text" class="form-control" name="npwp" value="" placeholder="Input NPWP" id="" >
                                </div>
                                <div class="modal-body">
                                <input type="text" class="form-control" name="nama" value="" placeholder="Input Nama" id="" >
                                </div>
                                <div class="modal-body">
                                <input type="text" class="form-control" name="no_hp" value="" placeholder="Input No Hp" id="" >
                                </div>
                                <div class="modal-body">
                                <input type="text" class="form-control" name="toko" value="" placeholder="Input Toko" id="" >
                                </div>
                                <div class="modal-body">
                                <select class="form-control" name="code_sales" required>
                                        <option value="">---Pilih Sales---</option>
                                        @foreach ($sales as $sale)
                                            <option  value="{{$sale->code_sales}}">{{$sale->nama_sales}}</option>
                                        @endforeach
                                      </select>                                
                                </div>
                                <div class="modal-body">
                                <label for="">Upload Ktp</label>
                                <input type="file" class="form-control" name="pict_ktp" value="" placeholder="Input Ktp" id="" >
                                </div>
                                <div class="modal-body">
                                    <textarea name="alamat" placeholder="Alamat" class="form-control form-control-sm" id=""></textarea>
                                </div>
                                <div class="modal-body">
                                       <select class="form-control" name="id_kab" id="kabupaten" required>
                                        <option value="">---Pilih Kabupaten/Kota---</option>
                                        @foreach ($kabupaten as $r_kab)
                                            <option  value="{{$r_kab->id}}">{{$r_kab->name}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                   <div class="modal-body">
                                       <select class="form-control" name="id_kec" id="kecamatan" required>
                                        <option value="">---Pilih Kecamatan---</option>
                                      </select>
                                    </div>
                                   <div class="modal-body">
                                       <select class="form-control" name="id_kel" id="desa" required>
                                        <option value="">---Pilih Desa---</option>
                                      </select>
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
<script>
        $('#kabupaten').change(function(){
    var kabID = $(this).val();    
    if(kabID){
        $.ajax({
           type:"GET",
           url:"customer.getKecamatan?kabID="+kabID,
           dataType: 'JSON',
           success:function(res){               
            if(res){
                $("#kecamatan").empty();
                $("#desa").empty();
                $("#kecamatan").append('<option>---Pilih Kecamatan---</option>');
                $("#desa").append('<option>---Pilih Desa---</option>');
                $.each(res,function(nama,kode){
                    $("#kecamatan").append('<option value="'+kode+'">'+nama+'</option>');
                });
            }else{
               $("#kecamatan").empty();
               $("#desa").empty();
            }
           }
        });
    }else{
        $("#kecamatan").empty();
        $("#desa").empty();
    }      
   });
 
   $('#kecamatan').change(function(){
    var kecID = $(this).val();    
    if(kecID){
        $.ajax({
           type:"GET",
           url:"customer.getDesa?kecID="+kecID,
           dataType: 'JSON',
           success:function(res){               
            if(res){
                $("#desa").empty();
                $("#desa").append('<option>---Pilih Desa---</option>');
                $.each(res,function(nama,kode){
                    $("#desa").append('<option value="'+kode+'">'+nama+'</option>');
                });
            }else{
               $("#desa").empty();
            }
           }
        });
    }else{
        $("#desa").empty();
    }      
   });
    </script>
@endpush          
@endsection
