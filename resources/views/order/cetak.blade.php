<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <title>Print</title>
</head>
<style>
    .oms{
        font-weight: 600;
    }
    .omset{
        font-weight: 400;
        margin-top: -14px;
    }
</style>
<body>
    <div class="container mt-4 mb-4">
        <div class="row">
            <div class="col-md-12">
                @foreach($namacabang as $cab)
                <h5 class="text-center">
                    LAPORAN KEUANGAN {{$cab->nama_cabang}}
                    <br>{{$cab->no_hp}}
                </h5>
                @endforeach
                <p class="text-center">
                {{ \Carbon\Carbon::parse($finalDate1)->isoFormat('dddd, D MMMM Y')}}-{{ \Carbon\Carbon::parse($finalDate2)->isoFormat('dddd, D MMMM Y')}}
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                           <div class="col-md-3 col-4">
                                <p class="oms">PENDAPATAN</p>
                            </div>
                            <div class="col-md-3 col-4 text-right">
                                <!--<p class="oms">HPP</p>-->
                            </div>
                            <div class="col-md-3 col-4 text-right">
                                <!--<p class="oms">NOMINAL</p>-->
                            </div>
                            <div class="col-md-3 col-4 text-right">
                                <p class="oms">NOMINAL</p>
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-md-3 col-4">
                                <p class="omset">SALES ORDER</p>
                                <p class="omset">SALES RETAIL ORIGINAL</p>
                                <p class="omset">SALES RETAIL UMKM-QU</p>
                                <p class="omset">SALES RETAIL UMKM</p>
                                <!--<p class="omset">UANG PELUNASAN</p>-->
                                <B>TOTAL PENDAPATAN</B>
                                
                            </div>
                             <div class="col-md-3 col-4 text-right">
                               
                            </div>
                            <div class="col-md-3 col-4 text-right">
                                
                            </div>
                            <div class="col-md-3 col-4 text-right">
                                <p class="omset">@currency($bayar) </p>
                                <p class="omset">@currency($original)</p>
                                <p class="omset">@currency($umkmqu)</p>
                                <p class="omset">@currency($umkm)</p>
                                <!--<p class="omset">@currency($pelunasan)</p>-->
                                <b>@currency($bayar + $original + $umkmqu + $umkm)</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                       <div class="row">
                           <div class="col-md-3 col-4">
                                <p class="oms">PENGELUARAN</p>
                            </div>
                            <div class="col-md-3 col-4 text-right">
                                <!--<p class="oms">HPP</p>-->
                            </div>
                            <div class="col-md-3 col-4 text-right">
                                <!--<p class="oms">NOMINAL</p>-->
                            </div>
                            <div class="col-md-3 col-4 text-right">
                                <p class="oms">NOMINAL</p>
                            </div>
                        </div>
                        <div class="row">
                          
                            <div class="col-md-4 col-4">
                            <table class="table table-borderless" >
                            <tr>
                                <th>Nama Pengeluaran</th>
                                <th>Total</th>
                            </tr>
                            @foreach($pengeluaran as $pen)
                            <tr>
                                <td>{{$pen->nama_barang}}</td>
                                <td>@currency($pen->total)</td>
                            </tr>
                            @endforeach
                               <tfoot>
                                   <tr>
                                       <td></td>
                                       <td><hr>@currency($pensum)</td>
                                   </tr>
                               </tfoot>
                               
                            </table>
                            
                            </div>
                            
                            <div class="col-md-4 col-4 text-left">
                               
                                <table class="table table-borderless" >
                            <tr>
                                <th>@currency($return)</th>
                               
                            </tr>
                            </table>
                            </div>
                            <div class="col-md-4 col-4 text-left">
                               
                                <table class="table table-borderless" >
                            <tr>
                                <th>@currency($bonus)</th>
                               
                            </tr>
                            </table>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <p class="oms">Pengeluaran</p>
                                <p class="oms">All Omset</p>
                               <br>
                                <b>BRUTO</b>
                            </div>
                            <div class="col-md-6 col-6 text-right">
                                <p class="omset mt-1">@currency($pensum)</p>
                                <p class="omset">@currency($bayar +  $original + $umkmqu + $umkm )</p>
                                <br>
                                <p class="omset">@currency(($bayar + $original + $umkmqu + $umkm ) - $pensum)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-6"></div>
            <div class="col-md-6 text-right">
                <p>Tanda Tangan</p>

                <p>{{Auth::user()->name}}</p>
                <hr class="float-right mt-5" style="width: 100px; border: 1px solid grey; ">
            </div>
        </div>

    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
        crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    -->
</body>

</html>
<script>
    window.print();
</script>