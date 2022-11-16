<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <title>HI-Code</title>
  </head>
  <style>
      html{
          overflow-x: hidden;
      }
      @font-face {
          font-family: hi;
          src: url("{{asset('assets/fonts/Technopollas.otf')}}");
      }
      .navbar{
          background: linear-gradient(to right, rgb(0, 140, 255), rgb(40, 94, 243));
          color: white;
      }
      .navbar, a{
          color: white;
      }
      .navbar-brand{
          font-family: hi;
      }
      .content{
         height: 480px;
         overflow-y: scroll;
         overflow-x: hidden;
      }

      .cart{
          font-family: hi;
      }

      @media screen and (max-width: 992px) {
      
    }

/* On screens that are 600px or less, set the background color to olive */
@media screen and (max-width: 600px) {
    .none{
          display: none;
      }
}
  </style>
  <body style="background-image:url('https://iversity.org/blog/wp-content/uploads/2015/06/bigstock-Business-doodles-Sketch-set-84640172.jpg')">
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top ">
        <div class="container">
            <a class="navbar-brand" href="{{route('gudang.transaksi')}}">HI-CODE</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ml-auto">
                <a class="nav-link ">Nama Kasir</a>
            </div>
            </div>
        </div>
      </nav>
           @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if (Session::has('success'))
            <div class="alert alert-success text-center">
                <p>{{ Session::get('success') }}</p>
            </div>
            @endif
      <div class="container-fluid">
        <div class="row" style="margin-top: 100px;">
            <!-- <div class="col-md-2 none" style="height: 600px; background-color: rgba(15, 224, 190, 0.692);"></div> -->
            <div class="col-md-8" style="height: 300px; ">
                <div class="row mt-3">
                    <div class="col-md-12" >
                        <h3 class="cart text-center">Product</h3>
                        
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <form action="">
                            <input type="text" class="form-control" name="cari" placeholder="Cari ... ">
                        </form>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                <div class="content mt-3"  style="background: rgba(13, 202, 114, 0.603); ">
                    <div class="row ">
                        @foreach($barang as $barangs)
                        <div class="col-md-4 mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-center">{{$barangs->code_barang_model}}</p>
                                    <p class="text-center"style="margin-top: -20px;">{{$barangs->nama_barang}}</p>
                                    <p class="text-center"style="margin-top: -20px;">{{$barangs->stok}}</p>
                                    <p class="text-center" style="margin-top: -20px;">@currency($barangs->harga_jual)</p>
                                    <a href="" style="width : 100%; font-family: hi" class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModal1<?php echo $barangs->id?>">Add
                                    </a>
                                </div>
                            </div>
                        </div>
    
    
                        <div class="modal fade" id="exampleModal1<?php echo $barangs->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                <div class="modal-header">
                                <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Qty</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('add')}}" method="post">
                                    @csrf
                                        <input type="hidden" class="form-control" name="id" value="{{$barangs->id}}" placeholder="Qty" id="">
                                        <input type="hidden" class="form-control" name="harga_pokok" value="{{$barangs->harga_pokok}}" placeholder="Qty" id="">
                                        <input type="hidden" class="form-control" name="harga_jual" value="{{$barangs->harga_jual}}" placeholder="Qty" id="">
    
                                        <input type="number" class="form-control" name="qty" placeholder="Qty" id="">
                                        <br>
                                        <input type="number" class="form-control" name="disc" placeholder="Discount" id="">
                                        <br>
                                        <input type="number" class="form-control" name="cut_sale" placeholder="Cut" id="">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" style="width : 100%; font-family: hi" class="btn btn-primary">Add to Cart</button>
                                    </form>
                                  </div>
                            </div>
                            </div>
                        </div>
                        @endforeach
                        
    
    
                    </div>
                </div>
            </div>
            <div class="col-md-4 pb-3 shadow" style="background: rgba(132, 160, 10, 0.692); ">
                 <div class="row mt-3">
                     <div class="col-md-12">
                         <h3 class="cart text-center">Cart</h3>
                         <p class="cart text-center">{{$kode}}</p>
                         <input type="hidden" class="form-control" name="no_invoice" value="{{$kode}}" placeholder="Discount" id="">
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-md-12">
                        <table class="table ">
                            <thead>
                              <tr>
                                <th scope="col" style="font-family: hi">Product</th>
                                <th scope="col" style="font-family: hi">Qty</th>
                                <th scope="col" style="font-family: hi">Harga</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                            <!-- foreach -->
                              @foreach($cart as $carts)
                              <tr>
                                  <td><strong>{{$carts->nama_barang}}
                                    <br>@currency($carts->harga_up)</strong></td>
                                  <td><strong>{{$carts->qty}}</strong></td>
                                  <td><strong>@currency($carts->sub_total)</strong></td>
                                  <td> <a href="" style="width : 100%; font-family: hi" class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModal2<?php echo $carts->id?>">Del
                                </a></td>
                              </tr>
                              <div class="modal fade" id="exampleModal2<?php echo $carts->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Reminder</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('hapusgudang')}}" method="post">
                                        @csrf
                                            <input type="hidden" class="form-control" name="id" value="{{$carts->id}}" placeholder="Qty" id="">
                                            <p class="cart text-center">Anda yakin ingin menghapus  {{$carts->nama_barang}} ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" style="width : 100%; font-family: hi" class="btn btn-danger">Yes</button>
                                        </form>
                                      </div>
                                </div>
                                </div>
                            </div>
                              @endforeach
                            </tbody>
                            <tfoot>
                            <form action="{{route('proses')}}" target="_blank" method="POST" enctype="multipart/form-data">
                             @csrf
                             <input type="hidden" name="no_invoice" value="{{$kode}}" placeholder="Enter subject" class="form-control" readonly />
                                <tr style="background: rgb(201, 235, 9)">
                                    <td colspan="2" style="font-family: hi;">Big Total</td>
                                    <td>@currency($big_total)</td>
                                    <td></td>
                               </tr>
                               <tr>
                                    <td style="font-family: hi">Bayar</td>
                                    <td colspan="2"><input type="text" name="bayar" value="" placeholder="Enter subject" class="form-control" required/></td>
                                    <td></td>
                               </tr>
                               <tr>
                                   <td></td>
                                   <td colspan="2"><button  style="background: rgba(12, 12, 12, 0.897); " type="submit" class="btn btn-outline-success btn-block">Save</button></td>
                                   <td></td>
                               </tr>
                            </form>
                            </tfoot>
                          </table>
                          
                             
                           
                     </div>
                 </div>
            </div>
          </div>
      </div>
      <!-- <footer class="footer" style="margin-top: 200px;">
        <div class=" container-fluid ">
          <div class="copyright" id="copyright">
            &copy; <script>
              document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
            </script>,Support System By HI-Code Solution Development <a href="#" target="_blank">Lukman & Zaki</a>.
          </div>
        </div>
      </footer> -->


    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    -->
</body>
</html>