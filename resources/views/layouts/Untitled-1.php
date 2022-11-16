<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav"><div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li class="active ">
            <a href="{{route('home')}}">
              <i class="now-ui-icons business_bank"></i>
              <p>Beranda</p>
            </a>
          </li>
          @if(Auth::user()->hak_akses == 'User')
          <li>
            <a href="{{route('resep.index')}}">
              <i class="now-ui-icons files_paper"></i>
              <p>Resep</p>
            </a>
          </li>
          <li>
            <a href="{{route('komponen.index')}}">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>Komponen</p>
            </a>
          </li>
    
           <li>
            <a href="{{route('komposisi.index')}}">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>Komposisi</p>
            </a>
          </li>
          <li>
          <li>
            <a href="{{route('order.index')}}">
              <i class="now-ui-icons shopping_bag-16"></i>
              <p>Order</p>
            </a>
          </li>
          <li>
            <a href="{{route('cabang.index')}}">
              <i class="now-ui-icons shopping_bag-16"></i>
              <p>cabang</p>
            </a>
          </li>
          <li>
            <a href="{{route('item.index')}}">
              <i class="now-ui-icons shopping_bag-16"></i>
              <p>Item</p>
            </a>
          </li>
          <li>
            <a href="{{route('paket.index')}}">
              <i class="now-ui-icons files_box"></i>
              <p>Paket</p>
            </a>
          </li>
          
         @elseif(Auth::user()->hak_akses == 'Kasir')
         
         <li>
            <a href="{{route('laporanorder')}}">
              <i class="now-ui-icons business_chart-bar-32"></i>
              <p>Laporan Harian</p>
            </a>
          </li>
          <li>
            <a href="{{route('retail.pos')}}">
              <i class="now-ui-icons tech_laptop"></i>
              <p>MENU POS</p>
            </a>
          </li>
           <li>
            <a href="{{route('retail.index')}}">
              <i class="now-ui-icons business_chart-bar-32"></i>
              <p>INVENTORY</p>
            </a>
          </li>
           <li>
            <a href="{{route('retail.databonus')}}">
              <i class="now-ui-icons emoticons_satisfied"></i>
              <p>DATA BONUS RETAIL</p>
            </a>
          </li>
           <li>
            <a href="{{route('retail.historyinven')}}">
              <i class="now-ui-icons emoticons_satisfied"></i>
              <p>HISTORY INVENTORY</p>
            </a>
          </li>
          <li>
            <a href="{{route('retail.historistok')}}">
              <i class="now-ui-icons emoticons_satisfied"></i>
              <p>HISTORY STOK</p>
            </a>
          </li>
            <li>
            <a href="{{route('item.index')}}">
              <i class="now-ui-icons shopping_tag-content"></i>
              <p>Item</p>
            </a>
          </li>
          <li>
            <a href="{{route('retail.notapos')}}">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>DATA TRANSAKSI POS</p>
            </a>
          </li>
           <li>
            <a href="{{route('retail.datareturn')}}">
              <i class="now-ui-icons loader_refresh"></i>
              <p>DATA RETURN</p>
            </a>
          </li>
           <li>
            <a href="{{route('retail.penjualanitem')}}">
              <i class="now-ui-icons shopping_basket"></i>
              <p>DATA PENJUALAN ITEM</p>
            </a>
          </li>
          <li>
            <a href="{{route('retail.datapenjualan')}}">
              <i class="now-ui-icons shopping_basket"></i>
              <p>DATA PENJUALAN RETAIL</p>
            </a>
          </li>
          <li>
            <a href="{{route('dataorder')}}">
              <i class="now-ui-icons education_agenda-bookmark"></i>
              <p>DATA ORDER</p>
            </a>
          </li>
         
          
         
          
          <!-- <li>
            <a href="{{route('dataprod')}}">
              <i class="now-ui-icons emoticons_satisfied"></i>
              <p>DATA ORDER PRODUKSI</p>
            </a>
          </li>
          <li>
            <a href="{{route('dataitem')}}">
              <i class="now-ui-icons emoticons_satisfied"></i>
              <p>DATA ITEM PRODUKSI</p>
            </a>
          </li> -->
           
          <li>
            <a href="{{route('packing')}}">
              <i class="now-ui-icons shopping_bag-16"></i>
              <p>DATA PACKING</p>
            </a>
          </li>
          <li>
            <a href="{{route('cataloge')}}">
              <i class="now-ui-icons education_agenda-bookmark"></i>
              <p>MENU ORDER</p>
            </a>
          </li>
         
          <li>
            <a href="{{route('paket.index')}}">
              <i class="now-ui-icons files_box"></i>
              <p>Paket</p>
            </a>
          </li>
          <li>
            <a href="{{route('komponen.index')}}">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>Komponen</p>
            </a>
          </li>
           <li>
            <a href="{{route('komposisi.index')}}">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>Komposisi</p>
            </a>
          </li>
          <li>
            <a href="{{route('resep.index')}}">
              <i class="now-ui-icons files_paper"></i>
              <p>Resep</p>
            </a>
          </li>
          <li>
            <a href="{{route('jenispengeluaran.index')}}">
              <i class="now-ui-icons arrows-1_cloud-upload-94"></i>
              <p>Jenis Pengeluaran</p>
            </a>
          </li>
          <li>
            <a href="{{route('pengeluarangudang.index')}}">
              <i class="now-ui-icons arrows-1_share-66"></i>
              <p>Pengeluaran</p>
            </a>
          </li>
          <li>
            <a href="{{route('akun.index')}}">
              <i class="now-ui-icons business_badge"></i>
              <p>User</p>
            </a>
          </li>
           <li>
            <a href="{{route('cabang.index')}}">
              <i class="now-ui-icons location_pin"></i>
              <p>cabang</p>
            </a>
          </li>
          <li>
            <a href="{{route('our_backup_database')}}">
              <i class="now-ui-icons location_pin"></i>
              <p>Download DB</p>
            </a>
          </li>
          <li> <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();"><i class="now-ui-icons media-1_button-power"></i><p>Logout</p></a>

                             <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                 @csrf
                             </form>
                </li>
          @elseif(Auth::user()->hak_akses == 'Produksi')
          <li>
            <a href="{{route('dataorder')}}">
              <i class="now-ui-icons education_agenda-bookmark"></i>
              <p>DATA ORDER</p>
            </a>
          </li>
          <li>
            <a href="{{route('packing')}}">
              <i class="now-ui-icons shopping_bag-16"></i>
              <p>DATA ORDER PACKING</p>
            </a>
          </li>
          <li>
            <a href="{{route('dataprod')}}">
              <i class="now-ui-icons education_agenda-bookmark"></i>
              <p>DATA ORDER PRODUKSI</p>
            </a>
          </li>
          <li>
            <a href="{{route('pengeluaranbahan')}}">
              <i class="now-ui-icons education_agenda-bookmark"></i>
              <p>DATA PENGELUARAN BAHAN</p>
            </a>
          </li>
          <li>
            <a href="{{route('dataitem')}}">
              <i class="now-ui-icons education_agenda-bookmark"></i>
              <p>DATA ITEM PRODUKSI</p>
            </a>
          </li>
          
          <!--<li>-->
          <!--  <a href="{{route('tampilpinjam')}}">-->
          <!--    <i class="now-ui-icons users_single-02"></i>-->
          <!--    <p>PIUTANG TO CABANG</p>-->
          <!--  </a>-->
          <!--</li>-->
          <!--<li>-->
          <!--  <a href="{{route('tocabang')}}">-->
          <!--    <i class="now-ui-icons users_single-02"></i>-->
          <!--    <p>HUTANG TO CABANG</p>-->
          <!--  </a>-->
          <!--</li>-->
          <li>
            <a href="{{route('formprod')}}">
              <i class="now-ui-icons users_single-02"></i>
              <p>TRANSAKSI GUDANG CABANG</p>
            </a>
          </li>
          <li>
              <a href="{{route('indexprod')}}">
                  <i class="now-ui-icons users_single-02">
                  </i>
                  <p>
                    LIST TRANSAKSI
                  </p>
              </a>
          </li>
          <li>
            <a href="{{route('bigwarehouse')}}">
              <i class="now-ui-icons business_bank"></i>
              <p>Warehouse Center</p>
            </a>
          </li>
          <li>
            <a href="{{route('gudangcabang.index')}}">
              <i class="now-ui-icons business_bank"></i>
              <p>Gudang Cabang</p>
            </a>
          </li>
          <li>
            <a href="{{route('purchase.index')}}">
              <i class="now-ui-icons education_paper"></i>
              <p>Purchase</p>
            </a>
          </li>
         
           <li>
            <a href="{{route('komponen.index')}}">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>Komponen</p>
            </a>
          </li>
           <li>
            <a href="{{route('komposisi.index')}}">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>Komposisi</p>
            </a>
          </li>
          <li>
            <a href="{{route('resep.index')}}">
              <i class="now-ui-icons files_paper"></i>
              <p>Resep</p>
            </a>
          </li>
          <li> <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();"><i class="now-ui-icons media-1_button-power"></i><p>Logout</p></a>

                             <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                 @csrf
                             </form>
                </li>
          @elseif(Auth::user()->hak_akses == 'Admin Financewarehouse')
         <li>
            <a href="{{route('modal.index')}}">
              <i class="now-ui-icons business_money-coins"></i>
              <p>Master Modal</p>
            </a>
          </li>
           <li>
            <a href="{{route('jenispengeluaran.index')}}">
              <i class="now-ui-icons arrows-1_cloud-upload-94"></i>
              <p>Jenis Pengeluaran</p>
            </a>
          </li>
          <li>
            <a href="{{route('pengeluarangudang.index')}}">
              <i class="now-ui-icons arrows-1_share-66"></i>
              <p>Pengeluaran</p>
            </a>
          </li>
          <li>
            <a href="{{route('laporan')}}">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>Laporan</p>
            </a>
          </li>
          <li>
            <a href="{{route('payment')}}">
              <i class="now-ui-icons shopping_credit-card"></i>
              <p>Payment Purchasing</p>
            </a>
          </li>
          <li>
            <a href="{{route('receive.index')}}">
              <i class="now-ui-icons shopping_credit-card"></i>
              <p>Payment Receiving</p>
            </a>
          </li>
          <li> <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();"><i class="now-ui-icons media-1_button-power"></i><p>Logout</p></a>

                             <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                 @csrf
                             </form>
                </li>
          @elseif(Auth::user()->hak_akses == 'Admin Bigwarehouse')
          <li>
            <a href="{{route('akun.index')}}">
              <i class="now-ui-icons users_single-02"></i>
              <p>User</p>
            </a>
          </li>
          <li>
            <a href="{{route('master')}}">
              <i class="now-ui-icons business_chart-bar-32"></i>
              <p>Master Inventory</p>
            </a>
          </li>
          <li>
            <a href="{{route('gudang.index')}}">
              <i class="now-ui-icons business_bank"></i>
              <p>Gudang</p>
            </a>
          </li>
          <li>
            <a href="{{route('gudang.transaksi')}}">
              <i class="now-ui-icons business_money-coins"></i>
              <p>Transaksi</p>
            </a>
        
          <!-- <li>
            <a href="{{route('pengeluarangudang.index')}}">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>Pengeluaran</p>
            </a>
          </li> -->
          <li>
            <a href="{{route('warehouse.indexkategori')}}">
              <i class="now-ui-icons arrows-1_cloud-download-93"></i>
              <p>KATEGORI</p>
            </a>
          </li>
          <li>
            <a href="{{route('receive.index')}}">
              <i class="now-ui-icons arrows-1_cloud-download-93"></i>
              <p>Receiving</p>
            </a>
          </li>
          
          <li>
            <a href="{{route('purchin')}}">
              <i class="now-ui-icons education_paper"></i>
              <p>Purchase In</p>
            </a>
          </li>
          <li>
            <a href="{{route('purchin')}}">
              <i class="now-ui-icons education_paper"></i>
              <p>Purchase In</p>
            </a>
          </li>
          <!-- <li>
            <a href="./typography.html">
              <i class="now-ui-icons ui-2_settings-90"></i>
              <p>Produksi</p>
            </a>
          </li>
          <li>
            <a href="{{route('bahanbaku.index')}}">
              <i class="now-ui-icons business_chart-pie-36"></i>
              <p>Bahanbaku</p>
            </a>
          </li> -->
          <li>
            <a href="{{route('satuan.index')}}">
              <i class="now-ui-icons media-2_sound-wave"></i>
              <p>Satuan</p>
            </a>
          </li>
          <!-- <li>
            <a href="{{route('komposisi.index')}}">
              <i class="now-ui-icons education_atom"></i>
              <p>Komposisi</p>
            </a>
          </li> -->
          <li>
            <a href="{{route('supplier.index')}}">
              <i class="now-ui-icons users_single-02"></i>
              <p>Supplier</p>
            </a>
          </li>
          <!-- <li>
            <a href="{{route('resep.index')}}">
              <i class="now-ui-icons files_paper"></i>
                <p>Resep</p>
   
            </a>
          </li> -->
          <li>
            <a href="{{route('cabang.index')}}">
              <i class="now-ui-icons location_map-big"></i>
              <p>cabang</p>
            </a>
          </li>
           <li>
            <a href="{{route('komponen.index')}}">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>Komponen</p>
            </a>
          </li>
           <li>
            <a href="{{route('komposisi.index')}}">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>Komposisi</p>
            </a>
          </li>
          <li>
            <a href="{{route('resep.index')}}">
              <i class="now-ui-icons files_paper"></i>
              <p>Resep</p>
            </a>
          </li>
          <li> <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();"><i class="now-ui-icons media-1_button-power"></i><p>Logout</p></a>

                             <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                 @csrf
                             </form>
                </li>
          @elseif(Auth::user()->hak_akses == 'Admin Gudangcabang')
          <li>
            <a href="{{route('formprod')}}">
              <i class="now-ui-icons users_single-02"></i>
              <p>TRANSAKSI GUDANG CABANG</p>
            </a>
          </li>
          <li>
              <a href="{{route('indexprod')}}">
                  <i class="now-ui-icons files_paper">
                  </i>
                  <p>
                    LIST TRANSAKSI
                  </p>
              </a>
          </li>
          <li>
            <a href="{{route('bigwarehouse')}}">
              <i class="now-ui-icons business_bank"></i>
              <p>Warehouse Center</p>
            </a>
          </li>
          <li>
            <a href="{{route('gudangcabang.index')}}">
              <i class="now-ui-icons business_bank"></i>
              <p>Gudang Cabang</p>
            </a>
          </li>
          <li>
            <a href="{{route('purchase.index')}}">
              <i class="now-ui-icons education_paper"></i>
              <p>Purchase</p>
            </a>
          </li>
         
          <!-- <li>
            <a href="./typography.html">
              <i class="now-ui-icons ui-2_settings-90"></i>
              <p>Produksi</p>
            </a>
          </li>
          <li>
            <a href="{{route('bahanbaku.index')}}">
              <i class="now-ui-icons business_chart-pie-36"></i>
              <p>Bahanbaku</p>
            </a>
          </li> -->
          <li>
            <a href="{{route('satuan.index')}}">
              <i class="now-ui-icons media-2_sound-wave"></i>
              <p>Satuan</p>
            </a>
          </li>
           <li>
            <a href="{{route('komponen.index')}}">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>Komponen</p>
            </a>
          </li>
           <li>
            <a href="{{route('komposisi.index')}}">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>Komposisi</p>
            </a>
          </li>
          <li>
            <a href="{{route('resep.index')}}">
              <i class="now-ui-icons files_paper"></i>
              <p>Resep</p>
            </a>
          </li>
          <li> <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();"><i class="now-ui-icons media-1_button-power"></i><p>Logout</p></a>

                             <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                 @csrf
                             </form>
                </li>
          @elseif(Auth::user()->hak_akses == 'Admin Premixwarehouse')
          
         <li>
            <a href="{{route('indexpremix')}}">
              <i class="now-ui-icons business_chart-bar-32"></i>
              <p>Master Inventory Premix</p>
            </a>
          </li>
          <li>
            <a href="{{route('gudang.index')}}">
              <i class="now-ui-icons business_bank"></i>
              <p>Gudang</p>
            </a>
          </li>
          <li>
            <a href="{{route('receive.index')}}">
              <i class="now-ui-icons arrows-1_cloud-download-93"></i>
              <p>Receiving</p>
            </a>
          </li>
          <li>
            <a href="{{route('purchase.index')}}">
              <i class="now-ui-icons education_paper"></i>
              <p>Purchase</p>
            </a>
          </li>
          <li>
            <a href="{{route('purchpremix')}}">
              <i class="now-ui-icons education_paper"></i>
              <p>Purchase In</p>
            </a>
          </li>
          <!-- <li>
            <a href="{{route('bahanbaku.index')}}">
              <i class="now-ui-icons business_chart-pie-36"></i>
              <p>Bahanbaku</p>
            </a>
          </li> -->
          <li>
            <a href="{{route('satuan.index')}}">
              <i class="now-ui-icons media-2_sound-wave"></i>
              <p>Satuan</p>
            </a>
          </li>
           <li>
            <a href="{{route('komponen.index')}}">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>Komponen</p>
            </a>
          </li>
           <li>
            <a href="{{route('komposisi.index')}}">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>Komposisi</p>
            </a>
          </li>
          <li>
            <a href="{{route('resep.index')}}">
              <i class="now-ui-icons files_paper"></i>
              <p>Resep</p>
            </a>
          </li>
          <li> <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();"><i class="now-ui-icons media-1_button-power"></i><p>Logout</p></a>

                             <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                 @csrf
                             </form>
                </li>
          @elseif(Auth::user()->hak_akses == 'Admin Eggwarehouse')
          <li>
            <a href="{{route('master')}}">
              <i class="now-ui-icons business_chart-bar-32"></i>
              <p>Master Inventory</p>
            </a>
          </li>
          <li>
            <a href="{{route('gudang.index')}}">
              <i class="now-ui-icons business_chart-bar-32"></i>
              <p>Inventory</p>
            </a>
          </li>
          <li>
            <a href="{{route('gudang.transaksi')}}">
              <i class="now-ui-icons gestures_tap-01"></i>
              <p>Transaksi</p>
            </a>
          </li>
          <li>
            <a href="{{route('receive.index')}}">
              <i class="now-ui-icons arrows-1_cloud-download-93"></i>
              <p>Receiving</p>
            </a>
          </li>
          <li>
            <a href="{{route('purchin')}}">
              <i class="now-ui-icons education_paper"></i>
              <p>Purchase In</p>
            </a>
          </li>
          <li>
            <a href="{{route('penjualangudang')}}">
              <i class="now-ui-icons education_paper"></i>
              <p>Penjualan</p>
            </a>
          </li>
          <!-- <li>
            <a href="{{route('bahanbaku.index')}}">
              <i class="now-ui-icons business_chart-pie-36"></i>
              <p>Bahanbaku</p>
            </a>
          </li> -->
          <li>
            <a href="{{route('satuan.index')}}">
              <i class="now-ui-icons media-2_sound-wave"></i>
              <p>Satuan</p>
            </a>
          </li>
        <li>
            <a href="{{route('supplier.index')}}">
              <i class="now-ui-icons business_badge"></i>
              <p>Supplier</p>
            </a>
          </li>
          <li>
            <a href="{{route('cabang.index')}}">
              <i class="now-ui-icons location_map-big"></i>
              <p>cabang</p>
            </a>
          </li>
          <li> <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();"><i class="now-ui-icons media-1_button-power"></i><p>Logout</p></a>

                             <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                 @csrf
                             </form>
                </li>
          @endif
          <!-- <li class="active-pro">
          <a class="nav-link  waves-effect waves-light" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();"><i class="now-ui-icons users_single-02"></i>Logout</a>

                             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                 @csrf
                             </form>
          </li> -->
        </ul>
      </div>
            <ul id="sidebarnav">

                <!-- @if(Auth::user()->hak_akses == 'Chiefstore' || Auth::user()->hak_akses =='Helpdesk')
                <li> <a class="waves-effect waves-dark" href="{{url('/')}}"><i class="icon-speedometer"></i><span class="hide-menu">Dashboard</span></a>
                </li>
                @endif
                @if(Auth::user()->hak_akses == 'User')
                <li> <a class="waves-effect waves-dark" href="{{route('user.index')}}"><i class="fas fa-file-import"></i><span class="hide-menu">Requestnote</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('akun.index')}}"><i class="fas fa-users-cog"></i><span class="hide-menu">Akun</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('cabang.index')}}"><i class="fas fa-clinic-medical"></i><span class="hide-menu">Cabang</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('penyebab.index')}}"><i class="fas fa-exclamation-circle"></i><span class="hide-menu">+ Penyebab</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('akibat.index')}}"><i class="fas fa-exclamation-triangle"></i><span class="hide-menu">+ Akibat</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('helpdesk.index')}}"><i class="far fa-file"></i><span class="hide-menu">Requestnote</span></a>
                </li>
                @elseif(Auth::user()->hak_akses == 'Chiefstore')
                <li> <a class="waves-effect waves-dark" href="{{route('chiefstore.index')}}"><i class="icon-speedometer"></i><span class="hide-menu">Requestnote</span></a>
                </li>
                @elseif(Auth::user()->hak_akses == 'Helpdesk' )
                <li> <a class="waves-effect waves-dark" href="{{route('akun.index')}}"><i class="fas fa-users-cog"></i><span class="hide-menu">Akun</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('cabang.index')}}"><i class="fas fa-clinic-medical"></i><span class="hide-menu">Cabang</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('penyebab.index')}}"><i class="fas fa-exclamation-circle"></i><span class="hide-menu">+ Penyebab</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('akibat.index')}}"><i class="fas fa-exclamation-triangle"></i><span class="hide-menu">+ Akibat</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('helpdesk.index')}}"><i class="far fa-file"></i><span class="hide-menu">Requestnote</span></a>
                </li>


                @elseif(Auth::user()->hak_akses == 'Infra' )
                <li> <a class="waves-effect waves-dark" href="{{route('infra.index')}}"><i class="far fa-file"></i><span class="hide-menu">Requestnote</span></a>
                </li>
                @elseif(Auth::user()->hak_akses == 'RnD' )
                <li> <a class="waves-effect waves-dark" href="{{route('rnd.index')}}"><i class="far fa-file"></i><span class="hide-menu">Requestnote</span></a>
                </li>
                @elseif(Auth::user()->hak_akses == 'Finance' )
                <li> <a class="waves-effect waves-dark" href="{{route('finance.index')}}"><i class="far fa-file"></i><span class="hide-menu">Requestnote</span></a>
                </li>
                @elseif(Auth::user()->hak_akses == 'Supplychain' )
                <li> <a class="waves-effect waves-dark" href="{{route('supplychain.index')}}"><i class="far fa-file"></i><span class="hide-menu">Requestnote</span></a>
                </li>
                @endif

 -->

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
