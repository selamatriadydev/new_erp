@extends('layouts/master')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">List Request</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">List Request</li>
            </ol>
        <a href="{{route('user.create')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
        </div>
    </div>
</div>
@if(session('pesan'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>{{session('pesan')}}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
<div class="card">
    <div class="card-body">

        <div class="table-responsive m-t-40">
            <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Action</th>
                        <th>NO REQ</th>
                        <th>Status</th>
                        <th>No Dokumen</th>
                        <th>Cabang</th>
                        <th>Penyebab</th>
                        <th>Permintaan</th>
                        <th>Akibat</th>
                      
                        
                    </tr>
                </thead>
                <tbody>
                   @foreach ($request as $item)
                    <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        @if($item->status == 'open')
                        <div class="btn-group">
                        <a href="{{route('user.edit',$item->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        </div>

                        <div class="btn-group">
                        <form action="{{route('user.destroy',$item->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                        </div>

                        @elseif($item->status == 'rejected')
                        <div class="btn-group">
                            <a href="{{route('user.edit',$item->id)}}" class="btn btn-success">Reopen</a>
                            </div>


                        @elseif($item->status == 'solved')
                        <div class="btn-group">
                            <a href="{{route('user.close',$item->id)}}" class="btn btn-dark">close</a>
                            </div>
                        @endif
                    </td> 
                    <td>{{$item->no_req}}</td>
                    <td>{{$item->status}}</td>
                    <td>{{$item->spk}}</td>
                    <td>{{$item->cabang->nama_cabang}}</td>
                    <td>{{$item->penyebab == null ? $item->dll_penyebab : $item->rel_penyebab->penyebab}}</td>
                    <td>{{$item->permintaan}}</td>
                    <td></td>
                    </tr>
                   @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
