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
                                                <h5><b>LAPORAN LABA/RUGI</b></h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <b>OMSET</b>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <b>@currency($omset)</b>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <b>HPP</b>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <b>@currency($omsetgudang1)</b>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <b>LABA KOTOR</b>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <b>@currency($omset - $omsetgudang1)</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="card" style="background: linear-gradient(to left, rgb(241, 158, 62), rgb(219, 101, 4)); color: white;">
                                        <div class="card-body pl-5">
                                             <div class="row">
                                                <h5><b>LAPORAN LABA NETT</b></h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <b>ZAKAT</b>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <b>@currency((($omset - $omsetgudang1)-$omsetgudang2)*(3/100))</b>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <b>CSR</b>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <b>@currency((($omset - $omsetgudang1)-$omsetgudang2)*(10/100))</b>
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
                                                        <b>@currency((($omset - $omsetgudang1)-$omsetgudang2)-(((($omset - $omsetgudang1)-$omsetgudang2)*(10/100))+((($omset - $omsetgudang1)-$omsetgudang2)*(3/100))))</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- kanan -->
                            <div class="col-md-6">
                                <!--  -->
                                <div class="card" style="background: linear-gradient(to right, blue, rgb(3, 208, 235)); color: white;">
                                    <div class="card-body pl-5">
                                        <div class="row">
                                            <h5><b>BIAYA</b></h5>
                                        </div>
                                        @foreach($pengeluaran as $pen)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>{{$pen->nama_pengeluaran}}</b>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>@currency($pen->sum)</b>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        <!-- <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>Biaya Kiriman</b>
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
                                                    <b>Biaya Operasional Gudang</b>
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
                                                    <b>Biaya Kontrakan</b>
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
                                                    <b>Biaya Lain-lain</b>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>@currency($omsetgudang2)</b>
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- <div class="row">
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
                                        </div>  -->
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>LABA/RUGI</b>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <b>@currency(($omset - $omsetgudang1)-$omsetgudang2)</b>
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
