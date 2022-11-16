@extends('layouts/master')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">

    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">


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
        <h4 class="card-title">Data Request</h4>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-file-export"></i> Export Excel
            </button>
            <br>
            <br>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="{{route('helpdesk.exportall')}}">All</a>
              <a class="dropdown-item" href="{{route('helpdesk.exportsolved')}}">Solved</a>
              <a class="dropdown-item" href="{{route('helpdesk.exportclose')}}">closed</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="btn btn-Secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-filter"></i> Filter
            </button>
            <br>
            <br>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="{{route('helpdesk.index')}}">All</a>
              <a class="dropdown-item" href="{{route('helpdesk.open')}}">Open</a>
              <a class="dropdown-item" href="{{route('helpdesk.approveshow')}}">Approve</a>
              <a class="dropdown-item" href="{{route('helpdesk.rejectedshow')}}">Reject</a>
              <a class="dropdown-item" href="{{route('helpdesk.close')}}">Close</a>
            </div>
        </div>
          {{-- <div class="btn-group">
            <a href="{{route('helpdesk.index')}}" class="btn btn-warning">All</a>
            <a href="{{route('helpdesk.open')}}" class="btn btn-success">Open</a>
            <a href="{{route('helpdesk.approveshow')}}" class="btn btn-primary">Approve</a>
            <a href="{{route('helpdesk.rejectedshow')}}" class="btn btn-danger">Reject</a>
            <a href="{{route('helpdesk.close')}}" class="btn btn-dark">Close</a>
        </div> --}}

        <div class="table-responsive m-t-40">
            <table id="user" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Action</th>
                        <th>Status</th>
                        <th>NO REQ</th>
                        <th>Pelapor</th>
                        <th>No SPK</th>
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
                        @if($item->status == 'approved')

                        <div class="btn-group">
                        <a href="{{route('helpdesk.proseshelpdesk',$item->id)}}" class="btn btn-success">Proses</a>
                        </div>
                        <div class="btn-group">
                            <button type="button" onclick="run('{{route('helpdesk.rejected',$item->id)}}')" class="btn btn-danger show-modal"><i class="fa fa-times"></i></button>
                        </div>

                        <div class="btn-group">

                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-share-square"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a href="{{route('helpdesk.forward',$item->id)}}" class="dropdown-item">Infra</a>
                                    <a href="{{route('helpdesk.forwardrnd',$item->id)}}" class="dropdown-item">Rnd</a>
                                    <a href="{{route('helpdesk.forwardfinance',$item->id)}}" class="dropdown-item">finance</a>
                                    <a href="{{route('helpdesk.forwardsupplychain',$item->id)}}" class="dropdown-item">Supplychain</a>
                                    </div>
                              </div>
                        </div>
                        <div class="btn-group">
                            <a href="{{route('helpdesk.print',$item->id)}}" class="btn btn-warning"><i class="fas fa-print"></i></a>
                        </div>
                        @elseif($item->proseshelp == Auth::user()->name && $item->status ==  'proses helpdesk')
                        <div class="btn-group">
                            <button type="button" onclick="run('{{route('helpdesk.solved',$item->id)}}')" class="btn btn-success show-modal"><i class="fa fa-check"></i></button>
                        </div>
                        <div class="btn-group">
                            <a href="{{route('helpdesk.unproseshelpdesk',$item->id)}}" class="btn btn-warning">BatalProses</a>
                        </div>
                        <div class="btn-group">
                            <a href="{{route('helpdesk.print',$item->id)}}" class="btn btn-warning"><i class="fas fa-print"></i></a>
                        </div>
                        @elseif($item->status !=  'open')
                        <div class="btn-group">
                            <a href="{{route('helpdesk.print',$item->id)}}" class="btn btn-warning"><i class="fas fa-print"></i></a>
                        </div>

                        @endif
                        <div class="btn-group">
                        <a onclick="view( {{$item->id}} )" class="btn btn-primary"><i class="fa fa-eye" style="color:white"></i></a>
                        </div>
                    </td>
                    <td>{{$item->status ." (". $item->updated_at.")"}}</td>
                    <td>{{$item->no_req}}</td>
                    <td>{{$item->pelapor}}</td>
                    <td>{{$item->spk}}</td>
                    <td>{{$item->cabang->nama_cabang}}</td>
                    <td>{{$item->penyebab == null ? $item->dll_penyebab : $item->rel_penyebab->penyebab}}</td>
                    <td>{{$item->permintaan}}</td>
                    <td>{{$item->akibat == null ? $item->dll_akibat : $item->rel_akibat->akibat}}</td>


                    </tr>
                   @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
    Launch demo modal
  </button> --}}

  <!-- Modal -->
  <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Detail Request Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
           <table id="view">
           <tr>
                   <td>Nomor  Request</td>
                   <td>:</td>
                   <td id="no_req">-</td>
               </tr>
               <tr>
                   <td>Pelapor</td>
                   <td>:</td>
                   <td id="pelapor">-</td>
               </tr>
               <tr>
                   <td>Permintaan</td>
                   <td>:</td>
                   <td id="permintaan">-</td>
               </tr>

               <tr>
                   <td>Status</td>
                   <td>:</td>
                   <td id="status">-</td>
               </tr>
               <tr>
                   <td>MetodeSolved</td>
                   <td>:</td>
                   <td id="metode">-</td>
               </tr>
               <tr>
                   <td>Approval</td>
                   <td>:</td>
                   <td id="chiefstore">-</td>
               </tr>
               <tr>
                   <td>Tgl Approve</td>
                   <td>:</td>
                   <td id="tgl_approved">-</td>
               </tr>
               <tr>
                   <td>Solved</td>
                   <td>:</td>
                   <td id="aktor">-</td>
               </tr>
               <tr>
                   <td>Tgl Solved</td>
                   <td>:</td>
                   <td id="tgl_solved">-</td>
               </tr>
               <tr>
                   <td>Tgl Close</td>
                   <td>:</td>
                   <td id="tgl_close">-</td>
               </tr>
               <tr>
                   <td>Lampiran</td>
                   <td>:</td>
                   <td id="lampiran">-</td>
               </tr>


           </table>
        </div>
        <div class="modal-footer">
        </div>

      </div>
    </div>


@push('myjs')
<script>
    function run(link){
        $('form#form-solved').attr('action',link);
        $('#myModal').modal('show');
        if(link.indexOf('reject') > -1){
            console.log('true');
            $('.modal-title').text('Isikan Alasan');
            $('.form-group').find('label').html('Alasan');
        }else{
            console.log('false');
            $('.modal-title').text('Isikan Metode');
            $('.form-group').find('label').html('Metode');
        }
    }

    function view(id){

        $.ajax({
            url : 'helpdesk/' + id ,
            success:function(data){

                var gambar = '<img src="imgreq/' + data.lampiran + '" alt="">';
                $('#pelapor').html(data.pelapor);
                $('#no_req').html(data.no_req);
                $('#permintaan').html(data.permintaan);
                $('#penyebab').html(data.penyebab);
                $('#akibat').html(data.akibat);
                $('#status').html(data.status);
                $('#metode').html(data.metode);
                $('#chiefstore').html(data.chiefstore);
                $('#tgl_approved').html(data.tgl_approved);
                $('#aktor').html(data.aktor);
                $('#tgl_solved').html(data.tgl_solved);
                $('#tgl_close').html(data.tgl_close);
                $('#lampiran').html(gambar);
                $('#viewModal').modal('show');

            }
        })
        

    }
</script>
@endpush
@endsection
