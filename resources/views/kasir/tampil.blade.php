<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!-- font  awesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <!-- font google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Petemoss&display=swap" rel="stylesheet">

    <title>Hello, world!</title>
  </head>

  <style>
      .cart:hover{
          cursor: pointer;
      }
      .drop{
         
          margin-top: -400px;
          margin-left: -60px;
          background-color: goldenrod;
      }
      .drop a{
          color: black;
      }
      .cards{
          padding: 0px;
          transition: all 1.5s ease;
      }
      .cards:hover{
        transform: scale(0.95);
      }
      a:hover{
          text-decoration: none;
      }
      .inner{
        overflow: hidden;
        }
      .inner img{
            transition: all 1.5s ease;
        }
        .inner:hover img{
            transform: scale(1.5);
        }
      @media screen and (max-width: 1024px) {
        .drop{
          margin-top: -400px;
          margin-left: -115px;
          background-color: goldenrod;
        }
        .drop a{
            color: black;
        }
        .h5 {
            font-size: 13px;
        }
        .harga{
            font-size: 10px;
        }
        .titik{
            font-size: 10px;
        }
        }
      @media screen and (max-width: 768px) {
        .drop{
          margin-top: -400px;
          margin-left: 0px;
          background-color: goldenrod;
        }
        .drop a{
            color: black;
        }
        .cart{
            margin-bottom: 80px;
        }
        .h5 {
            font-size: 13px;
        }
        .harga{
            font-size: 10px;
        }
        .titik{
            font-size: 10px;
        }
        }
      @media screen and (max-width: 411px) {
        .drop{
          margin-top: -140px;
          margin-left: 0px;
          background-color: rgb(255, 255, 255);
        }
        .drop a{
            color: goldenrod;
        }
        .h5 {
            font-size: 30px;
        }
        .harga{
            font-size: 25px;
        }
        .titik{
            font-size: 18px;
        }
        }
  </style>
  <body style="background : black;  background-size: cover;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <a href="{{route('paket.index')}}"><h1 style="font-family: 'Petemoss', cursive; color: rgb(218, 165, 32);  font-size: 90px;">Roti-Qu</h1></a>
            </div>
            <div class="col-md-3">

            </div>
            <div class="col-md-3">

            </div>
            <div class="col-md-3">
                
                <div class="card text-white text-center cart" style="background-color: rgba(0, 0, 0, 0.452);  border: none; ">
                <b class="mt-4"></b>
                    <i class="fab fa-opencart ml-4 mr-4 " style="font-size: 100px; color: goldenrod;"></i>
                    <b class="mt-2 mb-4"></b>
                    <button class="btn btn-outline-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Checkout
                    </button>
                    <div class="dropdown">
                    <div class="dropdown-menu drop" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="{{route('cekoutnew')}}">New Cust. Order</a>
                      <a class="dropdown-item" href="{{route('premixwarehouse')}}">Member Order</a>
                      <a class="dropdown-item" href="{{route('eggwarehouse')}}">POS</a>
                      <!-- <a class="dropdown-item" href="{{route('gudangcabang.index')}}">Gudang Cabang</a> -->
                    </div>
                </div>
                </div>
                
                
            </div>
        </div>
        <div class="row" style="margin-top: -80px;">
            <div class="col-md-6">
                <form action="" method="post">
                    <label for="" class="text-white">Cari</label>
                    <input type="text" class="form-control" name="scan" id="Search" onkeyup="myFunction()"  placeholder="Cari Paket"  autofocus>
                </form>
            </div>
            
        </div>
       
        <div class="row  mt-3">
            <div class="col-md-12">
                <div class="row">
                    <!-- foreach -->
                    @foreach($product as $prod)
                    <div class="col-md-3 mt-2">
                        <div class="card  cards text-white target" >
                            <a href=""   data-toggle="modal" data-target="#exampleModal1<?php echo $prod->id?>">
                            <div class="inner">
                                <img class="card-img" src="{{asset('images/'.$prod->gambar)}}" alt="">
                            </div>

                            <!-- <img src="IMG_20160218_105806-1_scaled.jpg" class="card-img" > -->
                            </a>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 style="color: brown;" class="h5">{{$prod->nama_paket}}</h5>

                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6 ">
                                        <b style="color: brown; margin-top: -100px;" class="harga">@currency($prod->harga_jual)</b>
                                    </div>
                                    <div class="col-md-6 text-right ">
                                        <a style="color: black;" class="titik" title="Detail" href="{{route('detailkasir',$prod->id)}}" ><i class="fas fa-ellipsis-v "></i></a>
                                        
                                    </div>
                                    
                                </div>
                                <!-- <button class="btn btn-outline-danger mt-2" href="{{route('detailkasir',$prod->id)}}" style="width: 100%;  border-radius: 20px;">Detail</i></button> -->
                            </div>
                        </div>
                       
                        <!-- Modal 1-->
                        <div class="modal fade" id="exampleModal1<?php echo $prod->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content" style="background-color: rgba(0, 0, 0, 0.39);">
                                <div class="modal-header">
                                <h5 class="modal-title text-white" id="exampleModalLabel">Qty</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('addtocart')}}" method="post">
                                    @csrf
                                        <input type="hidden" class="form-control" name="id_paket" value="{{$prod->id}}" placeholder="Qty" id="">
                                        <input type="hidden" class="form-control" name="harga_jual" value="{{$prod->harga_jual}}" placeholder="Qty" id="">

                                        <input type="number" class="form-control" name="qty" placeholder="Qty" id="">
                                        <br>
                                        <input type="hidden" class="form-control" name="disc" placeholder="Discount" id="">
                                        <br>
                                        <input type="hidden" class="form-control" name="cut_sale" placeholder="Cut" id="">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                                    </form>
                                  </div>
                            </div>
                            </div>
                        </div>
                        
                        <!-- Modal 2-->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Item</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                          <div class="carousel-item active">        
                                            <img class="d-block w-100" src="IMG_20160218_105806-1_scaled.jpg" alt="First slide">
                                                <div class="carousel-caption d-none d-md-block">
                                                    <h5>Nama Item</h5>
                                                    <b>Rp. 10.000</b>
                                                </div>
                                          </div>
                                          <div class="carousel-item">
                                            <img class="d-block w-100" src="IMG_20160218_105806-1_scaled.jpg" alt="Second slide">
                                                <div class="carousel-caption d-none d-md-block">
                                                    <h5>Nama Item</h5>
                                                    <b>Rp. 10.000</b>
                                                </div>
                                          </div>
                                          <div class="carousel-item">
                                            <img class="d-block w-100" src="IMG_20160218_105806-1_scaled.jpg" alt="Third slide">
                                                <div class="carousel-caption d-none d-md-block">
                                                    <h5>Nama Item</h5>
                                                    <b>Rp. 10.000</b>
                                                </div>
                                          </div>
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                          <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                          <span class="sr-only">Next</span>
                                        </a>
                                      </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- endforeach -->
                    
                    @endforeach
                    
                </div>
            </div>
                
        </div>
    </div>
    <footer >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="goldenrod" fill-opacity="1" d="M0,192L48,197.3C96,203,192,213,288,202.7C384,192,480,160,576,165.3C672,171,768,213,864,229.3C960,245,1056,235,1152,240C1248,245,1344,267,1392,277.3L1440,288L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
    </footer>






    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

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
    </script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    -->
  </body>
</html>