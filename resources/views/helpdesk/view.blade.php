@extends('layouts/master')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">View Detail Request Note</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
            </ol>
        <a href="{{route('akun.index')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
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
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="m-b-0 text-white">User Baru</h4>
            </div>
            <div class="card-body">
            <form action="" >
                @csrf
                @method('patch')
                    <div class="form-body">

                                <div class="form-group">
                                    <label for="">Nama</label>
                                <input type="text" name="name" value="{{$user->name}}" placeholder="Masukan Nama" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" name="email" value="{{$user->email}}" placeholder="Masukan Email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <select name="cabang_id" class="form-control">
                                        <option value="" disabled selected>--PIlih Cabang--</option>
                                        @foreach ($cabang as $item)
                                          <option {{$user->cabang_id == $item->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->nama_cabang}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="hak_akses" class="form-control">
                                        <option value="" disabled selected>--PIlih Hak Akses--</option>
                                        <option {{$user->hak_akses == 'User' ? 'selected' : ''}} >User</option>
                                        <option {{$user->hak_akses == 'Chiefstore' ? 'selected' : ''}}>Chiefstore</option>
                                        <option {{$user->hak_akses == 'Helpdesk' ? 'selected' : ''}}>Helpdesk</option>
                                        <option {{$user->hak_akses == 'Infra' ? 'selected' : ''}}>Infra</option>
                                        <option {{$user->hak_akses == 'RnD' ? 'selected' : ''}}>RnD</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                <input type="password" name="password" value="{{$user->password}}" placeholder="Password" class="form-control">
                                </div>
                                {{-- <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input type="text" name="confirm_password" placeholder="Confirm Password" class="form-control">
                                </div> --}}
                            </div>



                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
