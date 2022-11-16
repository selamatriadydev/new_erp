@extends('layouts/master')
@section('content')

<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Form New User</h4>
              </div>
              <div class="card-body">
                        <div class="btn-group">
                                <a href="{{route('akun.index')}}" class="btn btn-success">kembali</a>
                            </div>
            <form action="{{route('akun.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="form-body">
                    <input type="hidden" name="userstatus" value="aktif">


                                <div class="form-group">
                                    <label for="">Nama</label>
                                <input type="text" name="name" value="{{session('name')}}" placeholder="Masukan Nama" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" name="email" value="{{session('email')}}" placeholder="Masukan Email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <select name="cabang_id" class="form-control" required>
                                        <option value="" disabled selected>--PIlih Cabang--</option>
                                        @foreach ($cabang as $item)
                                          <option value="{{$item->id}}">{{$item->nama_cabang}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="hak_akses" class="form-control" required>
                                        <option value="" disabled selected>--PIlih Hak Akses--</option>
                                        <option >User</option>
                                        <option>Admin Bigwarehouse</option>
                                        <option>Admin Eggwarehouse</option>
                                        <option>Admin Premixwarehouse</option>
                                        <option>Admin Gudangcabang</option>
                                        <option>Admin Financewarehouse</option>
                                        <option>Kasir</option>
                                        <option>Produksi</option>
                                        <!-- <option>Helpdesk</option>
                                        <option>Infra</option>
                                        <option>RnD</option>
                                        <option>Finance</option>
                                        <option>Supplychain</option> -->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" name="password" placeholder="Password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Tanda Tangan</label>
                                    <input type="file" name="tandatangan" class="form-control">
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
