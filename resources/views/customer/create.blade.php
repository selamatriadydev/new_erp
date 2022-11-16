@extends('layouts/master')
@section('content')

<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> INPUT INVENTORY</h4>
              </div>
              <div class="card-body">
                        <div class="btn-group">
                                <a href="{{route('gudang.index')}}" class="btn btn-success">kembali</a>
                            </div>
            <form action="{{route('gudang.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if (Session::has('success'))
            <div class="alert alert-success text-center">
                <p>{{ Session::get('success') }}</p>
            </div>
            @endif
            <div class="form-group">
                                <label for="">Alamat</label>
                                <div class="row">
                                    <div class="col-md-4">
                                       <select class="form-select form-select-lg" name="kabupaten" id="kabupaten" required>
                                        <option value="">---Pilih Kabupaten/Kota---</option>
                                        @foreach ($kabupaten as $r_kab)
                                            <option  value="{{$r_kab->id}}">{{$r_kab->name}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="col-md-4">
                                       <select class="form-select form-select-lg" name="kecamatan" id="kecamatan" required>
                                        <option value="">---Pilih Kecamatan---</option>
                                      </select>
                                    </div>
                                    <div class="col-md-4">
                                       <select class="form-select form-select-lg" name="desa" id="desa" required>
                                        <option value="">---Pilih Desa---</option>
                                      </select>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <textarea name="jalan" placeholder="Jalan" class="form-control form-control-sm" id=""></textarea>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <textarea name="patokan" placeholder="Patokan" class="form-control form-control-sm" id=""></textarea>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <textarea name="keterangan" placeholder="Keterangan" class="form-control form-control-sm" id=""></textarea>
                                    </div>
                                </div>
                            </div>
        </form>
            </div>
        </div>
    </div>
</div>
@push('myjs')
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
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