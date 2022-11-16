@extends('layouts/master')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Request Note</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                {{-- <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Patient's Invoice</li> --}}
            </ol>

        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<!-- /.row -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div id="printable">
                <h3 class="text-center"><b>REQUEST NOTE</b></h3>
                <hr>

                    <table>
                        <tr>
                            <td>DIBUAT OLEH</td>
                            <TD>:</TD>
                            <td>{{$req->pelapor}}</td>
                        </tr>
                        <tr>
                            <td>CABANG</td>
                            <TD>:</TD>
                            <td>{{$req->cabang->nama_cabang}}</td>
                        </tr>
                        <tr>
                            <td>NO REQ</td>
                            <TD>:</TD>
                            <td>{{$req->no_req}}</td>
                        </tr>
                    </table>
                    <br> <br>
                    <strong style="display: inline-block">PERMINTAAN :</strong>
                    <table border="1" style="width:100%;height:20%;" >
                        <tr>
                            <td height="200" >{{$req->permintaan}}</td>
                        </tr>

                    </table>

                    <br> <br>
                    <strong style="display: inline-block">PENYEBAB :</strong>
                    <table border="1" style="width:100%;height:20%;" >
                        <tr>
                            <td height="200" >{{$req->penyebab == null ? $req->dll_penyebab : $req->rel_penyebab->penyebab}}</td>
                        </tr>

                    </table>

                    <br> <br>
                    <strong style="display: inline-block">AKIBAT / IMPACT :</strong>
                    <table border="1" style="width:100%;height:20%;" >
                        <tr>
                            <td height="200" >{{$req->akibat == null ? $req->dll_akibat : $req->rel_akibat->akibat}}</td>
                        </tr>

                    </table>
                    <br>
                    <table style="width:100%">
                        <tr>
                            <td></td>
                            <td class="float-right">{{$req->cabang->nama_cabang}}, {{date('d-m-Y', strtotime($req->tgl_approved)) }}</td>
                        </tr>
                        <tr>
                            <td>Created By</td>
                            <td class="float-right">Approved by</td>
                        </tr>
                    </table>
                <img src="{{asset('images/'.$user->tandatangan)}}" style="width:10%;height:10%;" alt="">
                <img class="float-right" src="{{asset('images/'.$chiefs->tandatangan)}}" style="width:10%;height:10%;" alt="">
                    <table style="width:100%">
                        <tr style="padding-top:100px;">
                            <td>{{$req->pelapor}}</td>
                            <td class="float-right">{{$req->chiefstore}}</td>
                        </tr>
                    </table>

                </div>

<br><br>
                        <div class="text-right">
                            <button id="cetak" class="btn btn-primary btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
                        </div>

            </div>
        </div>
    </div>
</div>

@push('myjs')
<script>
    $(document).ready(function(){
        $('#cetak').click(function(){
            $('#printable').print();
        })

    })
</script>
@endpush
@endsection

