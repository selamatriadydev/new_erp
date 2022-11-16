<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <title>Order</title>
</head>
<style>
     ::-webkit-scrollbar {
        width: 5px;
    }

    ::-webkit-scrollbar-track {
        background: #fff;
    }

    ::-webkit-scrollbar-thumb {
        background: orange;
        border-radius: 10px;
    }
    body{
        background-color: rgba(128, 128, 128, 0.13);
    }
    .head{
        background: linear-gradient(to right, orange, red);
        padding: 10px 0 3px 0;
        color: white;
        /* background-image: url("png.png"); */
        background-size: cover;
    }
    .card{
        box-shadow: 1px 1px 8px rgba(128, 128, 128, 0.151);
        border-radius: 10px;
    }
    .return{
        color: white;
    }
    .return:hover{
        color: red;
    }
    .kard{
        background-color: white;
        box-shadow: 1px 1px 8px rgba(128, 128, 128, 0.151);
        border-radius: 10px;
        padding: 12px 20px 12px 20px;
        color: grey;
    }
    .form-control-sm{
        border-radius: 8px;
    }
    .jmb{
        font-weight: 700;
        font-size: 20px;
    }
    .minmargin{
        margin-top: -20px;
        color: rgba(245, 245, 245, 0.74);
    }
</style>
<script>
    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
        var date = new Date();
        var day = date.getDate();
        var month = date.getMonth();
        var thisDay = date.getDay(),
            thisDay = myDays[thisDay];
        var yy = date.getYear();
        var year = (yy < 1000) ? yy + 1900 : yy;
</script>
<body>
    <div class="head">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <a href="{{route('cataloge')}}" class=" return"><i class="fa-solid fa-circle-arrow-left"></i></a>
                </div>
                <div class="col-md-4 text-center">
                    <p class="jmb">INVOICE</p>
                    <p class="minmargin">{{$no_invoice}}</p>
                </div>
                <div class="col-md-4 text-right">
                    <p>
                        <script>
                             document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year); 
                        </script>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
    <form action="{{route('invoice')}}" target="_blank" method="POST" enctype="multipart/form-data">
        @csrf
            <input type="hidden" class="form-control" name="no_invoice" value="{{$no_invoice}}">
            <div class="row">
                <div class="col-md-6 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Jenis Customer</label>
                                <select name="jeniscust" class="form-control form-control-sm" id="">
                                    <option value="#">--pilih--</option>
                                    <option value="Member">Member</option>
                                    <option value="Umum">Umum</option>
                                </select>
                            </div>
                            <!-- <div class="form-group">
                                <label for="">Cabang Produksi</label>
                                <select name="cabang" class="form-control form-control-sm" id="">
                                    <option value="#">--Pilih--</option>
                                </select>
                            </div> -->
                            <div class="form-group">
                                <label for="">Tanggal Kirim</label>
                                <input type="date" name="tanggal" class="form-control form-control-sm" id="">
                            </div>
                            <div class="form-group">
                                <label for="">Jam Kirim</label>
                                <input type="time" name="jam" class="form-control form-control-sm" id="">
                            </div>
                        </div>
                    </div>
                    <div class="kard mt-2">
                            Tetap Semangat dan yang Teliti Yah ... &#128518;&#128170;
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Nama Customer</label>
                                <input type="text" name="cust" class="form-control form-control-sm" id="">
                            </div>
                            <div class="form-group">
                                <label for="">No. Telepon</label>
                                <input type="text" name="telp" class="form-control form-control-sm" id="">
                            </div>
                            <div class="form-group">
                                <label for="">Jenis Order</label>
                                <select name="jenisorder" class="form-control form-control-sm" id="">
                                <option value="#">--pilih--</option>
                                <option value="Online">Online</option>
                                <option value="Offline">Offline</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Alamat</label>
                                <div class="row">
                                    <div class="col-md-4">
                                       <select class="form-select form-select-lg" name="kabupaten" id="kabupaten" required>
                                        <option value="">---Pilih Kabupaten/Kota---</option>
                                        @foreach ($kabupaten as $r_kab)
                                            <option  value="{{$r_kab->id}}">{{$r_kab->name}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="col-md-4">
                                       <select class="form-select form-select-lg" name="kecamatan" id="kecamatan" required>
                                        <option value="">---Pilih Kecamatan---</option>
                                      </select>
                                    </div>
                                    <div class="col-md-4">
                                       <select class="form-select form-select-lg" name="desa" id="desa" required>
                                        <option value="">---Pilih Desa---</option>
                                      </select>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <textarea name="jalan" placeholder="Jalan" class="form-control form-control-sm" id=""></textarea>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <textarea name="patokan" placeholder="Patokan" class="form-control form-control-sm" id=""></textarea>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <textarea name="keterangan" placeholder="Keterangan" class="form-control form-control-sm" id=""></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Diskon</th>
                                        <th scope="col">Potongan</th>
                                        <th scope="col">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($cart as $c)
                                <tr>
                                    <td>{{$c->nama_paket}}</td>
                                    <td>{{$c->qty}}</td>
                                    <td>{{$c->disc}} %</td>
                                    <td>@currency($c->cut_sale)</td>
                                    <td>@currency($c->subtotal)</td>
                                </tr>
                                @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Big Total</td>
                                        <td>@currency($big)</td>
                                        <input type="hidden" onKeyUp="kalkulatorTambah(getElementById('type1').value,this.value);" value="{{$big}}" readonly class="form-control" name="bigtotal" id="type1">
                                        <input type="hidden" class="form-control" name="bighpp" value="{{$bighpp}}">
                                        <!--<input type="hidden" class="form-control" name="bigtotal" value="{{$big}}">-->
                                    </tr>
                                    <tr style="border: none;">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Bayar</td>
                                        <td><input type="number" class="form-control form-control-sm text-center" name="bayar" placeholder="ini pake angka woy!!!" required id="type2"  onKeyUp="kalkulatorTambah(getElementById('type1').value,this.value);"></td>
                                        <!--<input type="hidden" class="form-control" name="bayar" value="{{$bayar}}">-->
                                    </tr>
                                    <tr style="border: none;">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Sisa</td>
                                        <td> <b class="produk" id="result"></b></td>
                                        <input type="hidden" class="form-control form-control-sm text-center" name="sisa" readonly name="sisa" id="kembalian">
                                        <!--<input type="hidden" class="form-control" name="sisa" value="{{$bayar - $big}}">-->

                                    </tr>
                                </tbody>
                            </table>
                            <button type="submit" class="btn float-right text-white" name="save" style="background-color: orange;">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>



    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
        crossorigin="anonymous"></script>
        <script>
        function myFunction() {
            var input = document.getElementById("Search");
            var filter = input.value.toLowerCase();
            var nodes = document.getElementsByClassName('target');

            for (i = 0; i < nodes.length; i++) {
                if (nodes[i].innerText.toLowerCase().includes(filter)) {
                    nodes[i].style.display = "block";
                } else {
                    nodes[i].style.display = "none";
                }
            }
        }


        

  function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function convertToRupiah(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
        return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
    }

    function kalkulatorTambah(type1, type2) {

        var a = parseInt(type1.replace(/,.*|[^0-9]/g, ''), 10); //eval(type1);
        var b = parseInt(type2.replace(/,.*|[^0-9]/g, ''), 10);
        var hasil = b - a;

        var jumlah = 'Rp. ' + hasil.toFixed(0).replace(/(d)(?=(ddd)+(?!d))/g, "$1.");
        //var total = NilaiRupiah(hasil);
        // console.info('hahah')
        document.getElementById('result').textContent = convertToRupiah(hasil);

        document.getElementById("kembalian").value = hasil; //document.getElementById("type2").value;

    }

    /* Tanpa Rupiah */
    var tanpa_rupiah = document.getElementById('type1');
    tanpa_rupiah.addEventListener('keyup', function (e) {
        tanpa_rupiah.value = formatRupiah(this.value);
    });
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $('#kabupaten').change(function(){
    var kabID = $(this).val();    
    if(kabID){
        $.ajax({
           type:"GET",
           url:"kasir.getKecamatan?kabID="+kabID,
           dataType: 'JSON',
           success:function(res){               
            if(res){
                $("#kecamatan").empty();
                $("#desa").empty();
                $("#kecamatan").append('<option>---Pilih Kecamatan---</option>');
                $("#desa").append('<option>---Pilih Desa---</option>');
                $.each(res,function(nama,kode){
                    $("#kecamatan").append('<option value="'+kode+'">'+nama+'</option>');
                });
            }else{
               $("#kecamatan").empty();
               $("#desa").empty();
            }
           }
        });
    }else{
        $("#kecamatan").empty();
        $("#desa").empty();
    }      
   });
 
   $('#kecamatan').change(function(){
    var kecID = $(this).val();    
    if(kecID){
        $.ajax({
           type:"GET",
           url:"kasir.getDesa?kecID="+kecID,
           dataType: 'JSON',
           success:function(res){               
            if(res){
                $("#desa").empty();
                $("#desa").append('<option>---Pilih Desa---</option>');
                $.each(res,function(nama,kode){
                    $("#desa").append('<option value="'+kode+'">'+nama+'</option>');
                });
            }else{
               $("#desa").empty();
            }
           }
        });
    }else{
        $("#desa").empty();
    }      
   });
    </script>
</body>

</html>