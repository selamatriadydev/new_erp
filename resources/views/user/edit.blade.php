@extends('layouts/master')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Form Request</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Form Request</li>
            </ol>
        <a href="{{route('user.index')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="m-b-0 text-white">Form Request</h4>
            </div>
            <div class="card-body">
            <form action="{{route('user.update',$request->id)}}" method="POST">
                @csrf
                @method('patch')
                    <div class="form-body">
                        <div class="row">
                            {{-- Sebelah Kiri --}}
                            <div class="col-md-6">
                            <input type="hidden" name="pelapor" value="{{Auth::user()->name}}">
                            <input type="hidden" name="cabang_id" value="{{Auth::user()->cabang_id}}">
                            <input type="hidden" name="status" value="{{$request->status}}">
                            <input type="hidden" name="tgl_approved">
                            <input type="hidden" name="aktor">
                            <input type="hidden" name="proseshelp">
                            <input type="hidden" name="prosesrnd">
                            <input type="hidden" name="chiefstore">
                            <input type="hidden" name="rejectchiefstore">
                            <input type="hidden" name="tgl_rejected">
                            <input type="hidden" name="tgl_solved">
                            <input type="hidden" name="tgl_close">
                            <div class="form-group">
                                <label for="">No Request</label>
                            <input type="text" name="no_req" value="{{$request->no_req}}" class="form-control" readonly>
                            </div>
                                <div class="form-group">
                                    <label for="">No Dokumen</label>
                                    <input type="text" name="spk" placeholder="No Dokumen" value="{{$request->spk}}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="">Permintaan</label>
                                    <input type="text" name="permintaan" placeholder="Permintaan" value="{{$request->permintaan}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Penyebab</label>
                                    {{-- <input type="text" name="penyebab" placeholder="Penyebab" class="form-control"> --}}
                                    <select id="penyebab" name="penyebab" class="form-control" required>
                                        <option disabled selected>--Pilih Penyebab--</option>
                                        @foreach($penyebab as $p)
                                            <option {{$request->penyebab == $p->id ? 'selected' : ''}} value="{{$p->id}}">{{$p->penyebab}}</option>
                                        @endforeach
                                        <option value="">Dll</option>
                                    </select>
                                    <input id="dllpenyebab" style="display:none" type="text" placeholder="Masukan penyebab lain" name="dll_penyebab" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="">Akibat</label>
                                    <select id="akibat" name="akibat" class="form-control" required>
                                        <option disabled selected>--Pilih Akibat--</option>
                                        @foreach($akibat as $a)
                                            <option {{$request->akibat == $a->id ? 'selected' : ''}} value="{{$a->id}}">{{$a->akibat}}</option>
                                        @endforeach
                                        <option value="">Dll</option>
                                    </select>
                                    <input id="dllakibat" style="display:none" type="text" placeholder="Masukan akibat lain" name="dll_akibat" class="form-control">
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('myjs')
<script>
    $(document).ready(function(){
        $('#penyebab').change(function(){
            var id = $('#penyebab').val();
            if(id == ''){
                $('#dllpenyebab').show();
            }else{
                $('#dllpenyebab').hide();
            }
        });
        $('#akibat').change(function(){
            var id = $('#akibat').val();
            if(id == ''){
                $('#dllakibat').show();
            }else{
                $('#dllakibat').hide();
            }
        });
    });
</script>
@endpush
@endsection
