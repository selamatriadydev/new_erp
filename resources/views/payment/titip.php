@extends('layouts/master')
@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> LAPORAN NERACA</h4>
              </div>
             
              <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <!-- kiri -->
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="card" style="background: linear-gradient(to left, rgb(3, 235, 3),green); color: white;">
                                        <div class="card-body pl-5">
                                             <div class="row">
                                                <h5><b>AKTIVA</b></h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <b>KAS</b>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <b>@currency($omsetgudang - ($omsetgudang1 + $omsetgudang2))</b>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <b>PIUTANG</b>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <b>@currency($sisa)</b>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <b>STOK BARANG</b>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <b>@currency($gudang)</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="row">
                                    <div class="card" style="background: linear-gradient(to left, yellow, rgb(250, 185, 5)); color: white;" >
                                        <div class="card-body pl-5">
                                        <div class="row">
                                            <h5><b>PASSIVA</b></h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>HUTANG</b>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>@currency($hutang)</b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>MODAL</b>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>@currency($omsetgudang1 + $omsetgudang2)</b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>LABA</b>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>@currency($omsetgudang - $omsetgudang1 )</b>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="row">
                                    <div class="card" style="background: linear-gradient(to left, rgb(255, 0, 98), rgb(250, 5, 5)); color: white;">
                                        <div class="card-body pl-5">
                                        <div class="row">
                                            <h5><b>LABA/RUGI</b></h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>OMSET</b>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>@currency($omsetgudang)</b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>BIAYA</b>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>@currency($omsetgudang2 + $bayarsup)</b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>LABA/RUGI</b>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>@currency($omsetgudang-($omsetgudang2 + $bayarsup))</b>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- kanan -->
                            <div class="col-md-6">
                                <div class="card" style="background: linear-gradient(to right, blue, rgb(3, 208, 235)); color: white;">
                                    <div class="card-body pl-5">
                                        <div class="row">
                                            <h5><b>OMSET</b></h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>Omset Gudang Besar</b>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>@currency($omsetgudangbesar)</b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>Omset Gudang Telur</b>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>@currency($omsetgudangtelur)</b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>Omset Gudang Premix</b>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>@currency($omsetgudangpremix)</b>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>Total Omset</b>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>@currency($omset)</b>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                <!--  -->
                                <div class="card" style="background: linear-gradient(to left, rgb(241, 158, 62), rgb(219, 101, 4)); color: white;">
                                    <div class="card-body pl-5">
                                        <div class="row">
                                            <h5><b>BIAYA</b></h5>
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>Biaya</b>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>Biaya Lain-Lain</b>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>@currency($omsetgudang2)</b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>Total Biaya</b>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>@currency($omsetgudang2)</b>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>LABA/RUGI</b>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>@currency($omsetgudang-($omsetgudang2 + $bayarsup))</b>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
            </div>
          </div>
           
@push('myjs')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<!-- <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> -->
<script>
    $(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
<!-- <script>
  $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script> -->

@endpush          
@endsection
