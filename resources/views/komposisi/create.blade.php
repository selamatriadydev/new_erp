@extends('layouts/master')
@section('content')

<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> KOMPOSISI</h4>
              </div>
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
              <div class="card-body">
                        <div class="btn-group">
                                <a href="{{route('komposisi.index')}}" class="btn btn-success">kembali</a>
                            </div>
            <form action="{{route('komposisi.store')}}" method="POST">
                @csrf
                    <div class="form-body">

                                <div class="form-group">
                                    <label for="">Nama resep</label>
                                    <select name="id_resep" class="form-control">
                                                <option value="" disabled selected>--Pilih Resep--</option>
                                                @foreach($resep as $pr)
                                                    <option value="{{$pr->id}}">{{$pr->nama_resep}}</option>
                                                @endforeach
                                    </select>                 
                                </div>
                                <div class="form-group">
                                    <label for="">Hasil jadi</label>
                                    <input type="number" name="hasil_jadi" class="form-control" required>
                                    <!--<input type="number" name="pembagi" placeholder="Masukan Nama" class="form-control">                 -->
                                </div>
                             
                                

                                <div class="table-responsive calculate-rows">
                                    <table class="table">
                                        <thead>
                                        <a href="#" class="btn newitem btn-primary tooltip-primary"><i class="fa fa-plus"></i> New Item</a>
                                        <tr>
                                            <th style="width:25%;">Bahanbaku</th>
                                            <th style="width:25%;">Quantity</th>

                                            <th style="width:4%;"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="addrow">
                                        <tr class="rows">
                                            <td style="border-top: none;">
                                            <select name="id_bahanbaku[]" class="form-control">
                                                <option value="" disabled selected>--Pilih Item--</option>
                                                @foreach($bahanbaku as $items)
                                                    <option value="{{$items->id}}">{{$items->nama_barang}} {{$items->berat}}{{$items->nama_satuan}}</option>
                                                @endforeach
                                            </select>  
                                            </td>
                                            <td style="border-top: none;">
                                            <input class="form-control"  type="text" name="quantity[]">
                                            </td>
                                            
                                            <td style="border-top: none;" class="text-center"><a class="removeitem" href="#"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </table>

                                    </div>
                    <button type="submit" class="btn btn-outline-success btn-block">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@push('myjs')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
    var wrapper = $('#addrow');
var newitem = $('.newitem');
var removeitem = $('.removeitem');
$(newitem).click(function(e) {
  e.preventDefault();
  $newrow = $('<tr class="rows"><td style="border-top: none;"><select name="id_bahanbaku[]" class="form-control"><option value="" disabled selected>--Pilih Item--</option>@foreach($bahanbaku as $items)<option value="{{$items->id}}">{{$items->nama_barang}} {{$items->berat}}{{$items->nama_satuan}}</option>@endforeach</select></td><td style="border-top: none;"><input class="form-control"  type="text" name="quantity[]"></td><td style="border-top: none;" class="text-center"><a class="removeitem" href="#"><i class="fa fa-times"></i></a></td></tr>');
  $(wrapper).append($newrow);
  $newrow.on("click", "a", function(e) {
    e.preventDefault();
    $(this).parent().parent().remove();
      calculate();
  });
});
$(removeitem).click(function(e) {
  e.preventDefault();
  $(this).parent().parent().remove();
    calculate();
});
</script>
@endpush
@endsection