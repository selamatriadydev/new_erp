@extends('layouts/master')
@section('content')

<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> PURCHASING</h4>
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
              <div class="card-body">
                            <div class="btn-group">
                                <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn btn-success">Kembali</a>
                            </div>
              </div>
              <form action="{{route('aksi',$qty->id)}}" method="POST">
                <div class="form-body">
                @csrf
                @method('patch')
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                    
                                            <div class="card-body">
                                                <label for="">No Purchase</label>
                                                <input type="text" name="no_purchase" value="{{$no}}" class="form-control" readonly>
                                            </div>
                                
                                        </div>
                                        <div class="col-md-6">
                                    
                                            <div class="card-body">
                                                <label for="">QTY old</label>
                                                <input type="text" name="" value="{{$qtyawal}}" class="form-control" readonly>
                                            </div>
                                
                                        </div>
                                        <div class="col-md-6">
                                    
                                            <div class="card-body">
                                                <label for="">Qty new</label>
                                                <input type="number" name="jumlah" value="" class="form-control" >
                                            </div>
                                
                                        </div>
                                    </div>                    
                                </div>
                    <button type="submit" class="btn btn-outline-success btn-block">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection