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
    <title>Point of Sales</title>
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
    .navbar{
        background: linear-gradient(to right, orange, rgb(255, 136, 0));
    }
    .card {
        border-radius: 10px;
    }

    .popup {
        cursor: pointer;
    }

    .stok {
        color: grey;
        font-size: 10px;
    }

    .harga {
        font-weight: 600;
        color: orange;
    }

    .produk {
        font-weight: 600;
        font-size: 12px;
    }

    .konten {
        height: 500px;
        overflow-y: scroll;
        overflow-x: hidden;
    }

    .wrap {
        border: 1px solid rgba(128, 128, 128, 0.24);
        border-radius: 8px;
        padding: 10px;
        font-size: 13px;
        box-shadow: 1px 1px 8px rgba(128, 128, 128, 0.151);
    }

    .wrapt {
        border: 1px solid rgba(128, 128, 128, 0.24);
        border-radius: 8px;
        padding: 10px 10px 0px 10px;
        font-size: 13px;
        box-shadow: 1px 1px 8px rgba(128, 128, 128, 0.151);
    }

    .kotak {
        box-shadow: 1px 1px 8px rgba(128, 128, 128, 0.151);
    }

    .icon {
        background-color: white;
        color: orange;
        border-radius: 50px;
    }

    @media only screen and (max-width: 1024px) {
        .harga {
            font-size: 12px;
            font-weight: 600;
            color: orange;
        }

        .wrap {
            border: 1px solid rgba(128, 128, 128, 0.24);
            border-radius: 8px;
            padding: 10px;
            font-size: 11px;
            box-shadow: 1px 1px 8px rgba(128, 128, 128, 0.151);
        }

        .wrapt {
            border: 1px solid rgba(128, 128, 128, 0.24);
            border-radius: 8px;
            padding: 10px 10px 10px 10px;
            font-size: 13px;
            box-shadow: 1px 1px 8px rgba(128, 128, 128, 0.151);
        }

        .stok {
            color: grey;
            font-size: 10px;
        }

        .harga {
            font-weight: 600;
            color: orange;
        }

        .cart {
            /* font-weight: 600; */
            font-size: 10px;
        }

        .produk {
            font-weight: 600;
            font-size: 10px;
        }
    }
</style>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand text-white" href="{{route('dataorder')}}">Sales Order</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto">
                    <!-- 
                            <li class="nav-item">
                                <a class="nav-link" href="#">Pricing</a>
                            </li> -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" role="button"
                            data-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#" style="color: red;" onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                               <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                 @csrf
                             </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- end -->
    <div class="container-fluid mt-5">
        <div class="row" style="margin-top: 50px;">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="input-group mb-2 mr-sm-2">
                            <input type="text" class="form-control" placeholder="Cari..." id="Search"
                                onkeyup="myFunction()">
                            <div class="input-group-prepend">
                                <div class="input-group-text icon"><i class="fas fa-search"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card konten" style="border: none;">
                            <div class="card-body">
                                <div class="row">
                                @foreach($product as $pro)
                                    <div class="col-md-4 mt-3">
                                        <div class="popup" data-toggle="modal" data-target="#exampleModal<?php echo $pro->id?>">
                                            <div class="card mt-2 kotak target">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <p>{{$pro->code_paket}}</p>
                                                            <b>{{$pro->nama_paket}}</b>
                                                            <p class="stok">12pcs</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 ">
                                                            <p class="harga">@currency($pro->harga_jual)</p>
                                                        </div>
                                                        <!--<div class="col-lg-6 ">-->
                                                        <!--    <img src="{{asset('images/'.$pro->gambar)}}" class="img-fluid"-->
                                                        <!--        style="border-radius: 10px; " alt="">-->
                                                        <!--</div>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal<?php echo $pro->id?>" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Produk</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <form action="{{route('addtocart')}}" method="post">
                                                      @csrf
                                                        <input type="hidden" class="form-control" name="no_invoice"  value="{{$kode}}" placeholder="...">

                                                        <input type="hidden" class="form-control" name="id" value="{{$pro->id}}" placeholder="Qty" id="">
                                                        <input type="hidden" class="form-control" name="code_komponen" value="{{$pro->code_komponen}}" placeholder="Qty" id="">
                                                        <input type="hidden" class="form-control" name="hpp" value="{{$pro->hpp}}" placeholder="hpp" id="">
                                                        <input type="hidden" class="form-control" name="harga_jual" value="{{$pro->harga_jual}}" placeholder="Qty" id="">
                                                        <input type="hidden" class="form-control" name="jenis_paket" value="{{$pro->jenis_paket}}" placeholder="Qty" id="">
                                                        @if($pro->jenis_paket == "Biasa")
                                                        
                                                        @php
                                                        $id_kom = $pro->id_komponen;
                                                        @endphp
                                                        @foreach($komponen->where('code_komponen',$id_kom) as $koms)
                                                        <select name="id_item" class="form-control">
                                                            <option value="" disabled selected>{{$koms->nama_item}}</option>
                                                            @foreach($item as $items)
                                                                <option value="{{$items->id}}">{{$items->nama_item}}</option>
                                                            @endforeach
                                                            </select>
                                                            <br>
                                                            @endforeach 
                                                            
                                                            
                                                        @else
                                                        <table class="table table-bordered" id="dynamicAddRemove">
                                                        <input type="hidden" class="form-control" name="id" value="{{$pro->id}}" placeholder="Qty" id="">
                                                        <tr>
                                                            <td>
                                                                <select name="addmore[0][id_item]" class="form-control">
                                                                    <option value="" disabled selected></option>
                                                                    @foreach($item as $items)
                                                                        <option value="{{$items->id}}">{{$items->nama_item}}</option>
                                                                    @endforeach
                                                                    </select>
                                                            </td>
                                                            
                                                            <td><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">+</button></td>
                                                        </tr>
                                                        </table>
                                                        @endif
                                                            <div class="form-group">
                                                            <input type="number" class="form-control" name="qty" placeholder="Qty" id="" autofocus required>
                                                            </div>
                                                            <div class="form-group">
                                                            <input type="number" class="form-control" name="disc" placeholder="Discount" id="">
                                                            </div>
                                                            <div class="form-group">
                                                            <input type="number" class="form-control" name="cut_sale" placeholder="Cut" id="">
                                                            </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 " style="border-left: 1px solid rgba(0, 0, 0, 0.308);">
                <div class="card cart mt-3" style="border: none;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h5>CART</h5>
                                <p style="color: grey;">{{$kode}}</p>
                            </div>
                        </div>
                        <div class="wrap">
                            <!-- cart -->
                            <div class="row">
                                <div class="col-md-2 col-2">Aksi</div>
                                <div class="col-md-4 col-4">
                                    <p class="cart">Product</p>
                                </div>
                                <div class="col-md-2 col-2">
                                    <p class="cart">Qty</p>
                                </div>
                                <div class="col-md-4 col-4">
                                    <p class="cart">SubTotal</p>
                                </div>
                            </div>

                            @foreach($cart as $c)
                            <div class="row ">
                                <div class="col-md-2 col-2">
                                    <a href="" class="x" style="color: red;" data-toggle="modal" data-target="#exampleModal2<?php echo $c->id?>"><i class="fas fa-trash"></i></a>
                                    <a href="" class="x" style="color: green;" data-toggle="modal" data-target="#exampleModal6<?php echo $c->id?>"><i class="fas fa-edit"></i></a>
                                </div>
                               
                                <div class="col-md-4 col-4">
                                    <p class="produk">{{$c->nama_paket}}</p>
                                </div>
                                <div class="col-md-2 col-2">
                                    <p class="produk">{{$c->qty}}</p>
                                </div>
                                <div class="col-md-4 col-4">
                                    <p class="produk">@currency($c->subtotal)</p>
                                </div>
                            </div>

                            <!-- hapus -->
                            <div class="modal fade" id="exampleModal2<?php echo $c->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Reminder</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('deletebar')}}" method="post">
                                        @csrf
                                            <input type="hidden" class="form-control" name="id" value="{{$c->id}}" placeholder="Qty" id="">
                                            <p class="cart text-center">Anda yakin ingin menghapus  {{$c->nama_paket}} ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" style="width : 100%; font-family: hi" class="btn btn-danger">Yes</button>
                                        </form>
                                      </div>
                                </div>
                                </div>
                            </div>
                            <!-- endhapus -->
                            <!-- edit -->
                            <div class="modal fade" id="exampleModal6<?php echo $c->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content" style="background-color: rgba(26, 175, 175, 0.719);">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-white" style="width : 100%; font-family: hi" id="exampleModalLabel">Edit Quantity</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('editqu')}}" method="post">
                                        @csrf
                                            <input type="hidden" class="form-control" name="id" value="{{$c->id}}" placeholder="Qty" id="">
                                            <input type="hidden" class="form-control" name="id_paket" value="{{$c->id_paket}}" placeholder="Qty" id="">
                                            <input type="number" class="form-control" name="qty" value="{{$c->qty}}" placeholder="Qty" id="">
                                            <input type="hidden" class="form-control" name="disc" value="{{$c->disc}}" placeholder="Qty" id="">
                                            <input type="hidden" class="form-control" name="cutsale" value="{{$c->cut_sale}}" placeholder="Qty" id="">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" style="width : 100%; font-family: hi" class="btn btn-danger">Yes</button>
                                        </form>
                                      </div>
                                </div>
                                </div>
                            </div>
                            <!-- endedit -->
                            
                            @endforeach
                        </div>

                        <div class="wrap mt-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <p>Total</p>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <b>@currency($big)</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <!--<p>Bayar</p>-->
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                <form action="{{route('cekoutnew')}}" target="_blank" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" class="form-control" name="no_invoice"  value="{{$kode}}" placeholder="...">

                                    <!--<input type="text" class="form-control" name="bayar" placeholder="...">-->
                                </div>
                            </div>
                        </div>
                        <div class="wrapt mt-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <!--<p>Kembalian</p>-->
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <!--<b class="produk">Rp. 10.000</b>-->
                                    <!--<input type="hidden" class="form-control form-control-sm text-center"-->
                                    <!--    name="kembalian" readonly>-->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn w-100 mt-2 text-white"
                                    style="background-color: orange;">Payment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
    </script>
    <script type="text/javascript">
    var i = 0;
    $("#dynamic-ar").click(function () {
        ++i;
        $("#dynamicAddRemove").append('<tr><td><select name="addmore['+i+'][id_item]" class="form-control"><option value="" disabled selected></option>@foreach($item as $items)<option value="{{$items->id}}">{{$items->nama_item}}</option>@endforeach</select></td><td><button type="button" name="add" id="remove-input-field" class="btn btn-danger">x</button></td></tr>');
    });
    $(document).on('click', '#remove-input-field', function () {
        $(this).parents('tr').remove();
    });
</script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    -->
</body>

</html>