@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Simple Table</h4>
              </div>
              <div class="card-body">
                        <div class="btn-group">
                                <a href="{{route('akun.index')}}" class="btn btn-success">kembali</a>
                            </div>
            <form action="{{route('akun.update',$user->id)}}" method="POST">
                @csrf
                @method('patch')
                    <div class="form-body">

                                <div class="form-group">
                                    <label for="">Nama</label>
                                <input type="text" name="name" value="{{$user->name}}" placeholder="Masukan Nama" class="form-control" readonly>
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
                                        <option {{$user->hak_akses == 'Admin Bigwarehouse' ? 'selected' : ''}}>Admin Bigwarehouse</option>
                                        <option {{$user->hak_akses == 'Admin Eggwarehouse' ? 'selected' : ''}}>Admin Eggwarehouse</option>
                                        <option {{$user->hak_akses == 'Admin Premixwarehouse' ? 'selected' : ''}}>Admin Premixwarehouse</option>
                                        <option {{$user->hak_akses == 'Admin Gudangcabang' ? 'selected' : ''}}>Admin Gudangcabang</option>
                                        <option {{$user->hak_akses == 'Admin Financewarehouse' ? 'selected' : ''}}>Admin Financewarehouse</option>
                                        <option {{$user->hak_akses == 'Kasir' ? 'selected' : ''}}>Kasir</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                <input type="password" name="password" value="{{$user->password}}" placeholder="Password" class="form-control">
                                </div>
                                <!-- {{-- <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input type="text" name="confirm_password" placeholder="Confirm Password" class="form-control">
                                </div> --}} -->
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
