<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\GudangCabangModel;
use App\Http\Controllers\GudangCabangController;
use Illuminate\Support\Facades\Route;



Route::get('/', 'HomeController@index')->name('home');
Route::get('getcount','HomeController@getcount');
Route::get('getcountchiefstore','HomeController@getcountchiefstore');
Route::get('getcountrnd','HomeController@getcountrnd');
Route::get('getcountinfra','HomeController@getcountinfra');
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'UserController');
    Route::get('user/{id}/close','UserController@close')->name('user.close');
    Route::get('user/{id}/reopen','UserController@reopen')->name('user.reopen');


});
Route::resource('cabang', 'CabangController');
    Route::resource('order','OrderController');
    Route::resource('item','ItemController');
    Route::resource('paket','PaketController');
    Route::post('paket.ubah','PaketController@ubah')->name('paket.ubah');
    Route::resource('bahanbaku','BahanbakuController');
    Route::resource('satuan','SatuanController');
    Route::resource('resep','ResepController');
    Route::resource('komposisi','KomposisiController');
    Route::resource('gudang','GudangController');
    Route::resource('retail','InventoryRetailController');
    Route::resource('gudangcabang','GudangCabangController');
    Route::resource('komponen','KomponenController');
    Route::resource('modal','ModalController');
    Route::resource('transaksi','TransaksiController');
    // new
    Route::get('customer.index','CustomerController@data_customer')->name('data.customer');
  
    Route::get('customer.getKecamatan', 'CustomerController@getKecamatan');
    Route::get('customer.getDesa', 'CustomerController@getDesa');
    Route::get('sales/index','SalesController@data_sales')->name('data.sales');
    Route::post('sales/index','SalesController@input_sales')->name('input.sales');
    Route::get('customer.create','CustomerController@create_customer')->name('create.customer');
    Route::post('customer/input','CustomerController@input_cust')->name('input_cust');
  
    // 
    // new
    Route::get('/our_backup_database', 'TransaksiController@our_backup_database')->name('our_backup_database');
    Route::get('retail.index','RetailController@index')->name('retail.index');
    Route::get('retail.historyinven','RetailController@historyinven')->name('retail.historyinven');
    Route::get('retail.filterhistoryinven','RetailController@filterhistoryinven')->name('retail.filterhistoryinven');
    Route::get('retail.historistok','RetailController@historistok')->name('retail.historistok');
    Route::get('retail.filterhistoristok','RetailController@filterhistoristok')->name('retail.filterhistoristok');
    Route::get('warehouse/indexkategori','WarehouseController@indexkategori')->name('warehouse.indexkategori');
    Route::post('warehouse.inputkat','WarehouseController@inputkat')->name('warehouse.inputkat');
    Route::post('warehouse.editkat','WarehouseController@editkat')->name('warehouse.editkat');
    Route::post('warehouse/detail','WarehouseController@detailpre')->name('warehouse.detail');
    Route::get('retail.pos','RetailController@pos')->name('retail.pos');
    Route::get('retail.datapos','RetailController@notapos')->name('retail.notapos');
    Route::get('retail.filterdatapos','RetailController@filternotapos')->name('filterdatapos');
    Route::get('order.filterpengeluaranbahanbaku','TransaksiController@filterpengeluaranbahanbaku')->name('filterpengeluaranbahanbaku');
    Route::get('retail.filterdatareturn','RetailController@filterdatareturn')->name('filterdatareturn');
    Route::get('retail.filterdatabonus','RetailController@filterdatabonus')->name('filterdatabonus');
    Route::post('retail.detailnota','RetailController@detailnota')->name('retail.detailnota');
    Route::get('retail.datapenjualan','RetailController@datapenjualan')->name('retail.datapenjualan');
    
    Route::get('retail.filterdatapenjualan','RetailController@filterdatapenjualan')->name('filterdatapenjualan');
    Route::get('retail.penjualanitem','RetailController@penjualanitem')->name('retail.penjualanitem');
    Route::get('retail.filterpenjualanitem','RetailController@filterpenjualanitem')->name('retail.filterpenjualanitem');
    Route::post('retail.addcart','RetailController@addcart')->name('retail.addcart');
    Route::post('retail.deleteretail','RetailController@deleteretail')->name('retail.deleteretail');
    Route::post('retail.editretail','RetailController@editretail')->name('retail.editretail');
    Route::post('retail.invoice','RetailController@invoice')->name('retail.invoice');
    Route::get('retail.create','RetailController@create')->name('retail.create');
    Route::post('retail.store','RetailController@store')->name('retail.store');
    Route::post('retail.restokretail','RetailController@restokretail')->name('retail.restokretail');
    Route::post('retail.bonusretail','RetailController@bonusretail')->name('retail.bonusretail');
    Route::post('retail.returnretail','RetailController@returnretail')->name('retail.returnretail');
    Route::get('retail.datareturn','RetailController@datareturn')->name('retail.datareturn');
    Route::get('retail.databonus','RetailController@databonus')->name('retail.databonus');



// end

    Route::get('warehouse.indexmaster','WarehouseController@index')->name('master');
    Route::post('warehouse.filterkategori','WarehouseController@filterkategori')->name('filterkategori');
    Route::get('warehouse.indexpremix','WarehouseController@indexpremix')->name('indexpremix');
    Route::post('gudang/restokpremix','GudangController@restokpremix')->name('restokpremix');
    Route::get('warehouse.createmaster','WarehouseController@create')->name('create');
    Route::post('warehouse.hapus','WarehouseController@hapus')->name('haps');
    Route::get('order.data','TransaksiController@dataorder')->name('dataorder');
    Route::get('order.laporan','TransaksiController@laporan')->name('laporanorder');
    Route::get('order.cetak','TransaksiController@filterlaporanorder')->name('filterlaporanorder');
    Route::get('order.filterdata','TransaksiController@filterdataorder')->name('filterdataorder');
    Route::get('order.filterdataproduksi','TransaksiController@filterdataproduksi')->name('filterdataproduksi');
    Route::get('order.filterdatamasukproduksi','TransaksiController@filterdatamasukproduksi')->name('filterdatamasukproduksi');
    Route::get('order.filterkirim','TransaksiController@filterkirimorder')->name('filterkirimorder');
    Route::get('order.pengeluaranbahan','TransaksiController@datapengeluaranbahanbaku')->name('pengeluaranbahan');
    Route::get('order.filterpacking','TransaksiController@filterpacking')->name('filterpacking');
    Route::get('order.packing','TransaksiController@dataorderpacking')->name('packing');
    Route::get('dashboard.index','TransaksiController@dashboard')->name('dash');
    Route::get('order.orderprod','TransaksiController@dataprod')->name('dataprod');
    Route::post('order.produksi','TransaksiController@produksi')->name('produksi');
    Route::post('order.cancel','TransaksiController@cancel')->name('cancel');
    Route::post('order.selesai','TransaksiController@selesai')->name('selesai');
    Route::post('order.edittime','TransaksiController@edittime')->name('edittime');
    Route::get('order.dataitem','TransaksiController@dataitem')->name('dataitem');
    Route::get('order.filterdataitem','TransaksiController@filterdataitem')->name('filterdataitem');
    Route::post('order.print','TransaksiController@print')->name('printorder');
    Route::post('order.data','TransaksiController@bayar')->name('pelunasanorder');
    Route::post('warehouse.input','WarehouseController@store')->name('storemaster');
    Route::get('gudang.transaksi','TransaksiGudangController@index')->name('gudang.transaksi');
    Route::get('gudang.transak','TransaksiGudangController@create')->name('gudang.transak');
    Route::post('gudang/restokbarang','GudangController@restokbarang')->name('restokbarang');
    Route::post('gudang/restok','WarehouseController@restok')->name('restok.gudang');
    Route::post('gudang/restokpremix','GudangController@restokpremix')->name('restokpremix');
    Route::post('gudang/hapus','TransaksiGudangController@remove')->name('hapusgudang');
    Route::post('kasir/deletbar','KasirController@deletbar')->name('deletebar');
    Route::post('kasir/editqu','KasirController@editqu')->name('editqu');
    Route::post('kasir/invoice','TransaksiController@invoice')->name('invoice');
    Route::post('gudang/add','TransaksiGudangController@add')->name('add');
    Route::post('gudang/proses','TransaksiGudangController@invoicing')->name('proses');
    Route::post('kasir/addcart','TransaksiController@addtocart')->name('addtocart');
    Route::get('gudang/{id}/print','TransaksiGudangController@print')->name('print');
    Route::get('gudang/{id}/detailgud','TransaksiGudangController@detail')->name('detailgud'); 
    Route::post('kasir.cekoutnew','TransaksiController@cekoutnew')->name('cekoutnew');
    Route::get('purprod.create','PurchaseController@formprod')->name('formprod');
    Route::post('purprod/storeprod','PurchaseController@storeprod')->name('storeprod');
    Route::get('purprod.index','PurchaseController@indexprod')->name('indexprod');
    Route::get('purprod/{id}/detailprod','PurchaseController@detailprod')->name('detailprod'); 
    Route::get('paket/{id}/detail','PaketController@detail')->name('detailpaket');
    Route::get('komponen/{id}/detail','KomponenController@detail')->name('detailkomponen');
    Route::get('komposisi/{id}/detail','KomposisiController@detail')->name('detailkom');
    Route::post('komponen/hapus','KomponenController@hapuskomponen')->name('hapuskomponen');
    Route::post('item/edit_item','ItemController@edit_item')->name('edit_item');
    Route::get('item/{id}/detail','ItemController@detail')->name('detailitem');
    Route::get('kasir.product','KasirController@tampil')->name('tampilkasir');
    Route::get('kasir/{id}/detail','KasirController@detail')->name('detailkasir');
    Route::get('kasir/cataloge','KasirController@cataloge')->name('cataloge');
    Route::resource('receive','ReceiveController');
    Route::get('receive/{id}/detailbarangmasuk','ReceiveController@detailbarangmasuk')->name('cek');
    Route::get('purchase/premix','PurchaseController@premix')->name('purchase.premix');
    Route::get('purchase/egg','PurchaseController@egg')->name('purchase.egg');
    Route::get('gudang.createpremix','GudangController@createpremix')->name('createpremix');
    Route::post('gudang/storepremix','GudangController@storepremix')->name('storepremix');
    Route::post('warehouse/editmas','WarehouseController@editmas')->name('editmas');
    Route::get('gudang/{id}/detail','GudangController@detailgudangs')->name('detailgudangs');
    Route::get('gudang/{id}/editbarang','GudangController@editbarang')->name('editbarang');
    Route::patch('gudang/{id}/editbarang','GudangController@updatebarang')->name('updatebarang'); 
    Route::get('penjualangudang/penjualan','PurchaseController@penjualan')->name('penjualangudang');
    Route::get('purchase/big','PurchaseController@big')->name('purchase.big');
    Route::get('gudangcabang.filter','GudangCabangController@filter')->name('filter');
    Route::get('gudangcabang.pinjam','GudangCabangController@pinjam')->name('pinjam');
    Route::get('gudangcabang/{id}/edit','GudangCabangController@edit')->name('edit');
    Route::patch('gudangcabang/{id}/update','GudangCabangController@update')->name('update');
    Route::delete('gudangcabang/{id}/delete','GudangCabangController@destroy')->name('destroy');
    Route::get('peminjam.tampil','GudangCabangController@tampil_peminjaman')->name('tampilpinjam');
    Route::get('peminjam/{id}/detail','GudangCabangController@detail_pinjam')->name('detailpeminjaman');
    Route::resource('supplier','SupplierController');
    Route::resource('purchase','PurchaseController');
    Route::resource('pengeluarangudang','PengeluaranGudangController');
    Route::resource('jenispengeluaran','JenisPengeluaranController');
    Route::get('purchase.check','PurchaseController@check')->name('check');
    Route::get('gudang.bigwarehouse','GudangController@bigwarehouse')->name('bigwarehouse');
    Route::get('payment.payment','PurchaseController@payment')->name('payment');
    Route::get('payment.laporan','PurchaseController@laporanpayment')->name('laporan');
    Route::get('payment/{id}/detailbarang','PurchaseController@detailbarang')->name('detailbarang');
    Route::get('payment/{id}/detailpayment','PurchaseController@detailpayment')->name('detailpayment');
    Route::get('gudang.eggwarehouse','GudangController@eggwarehouse')->name('eggwarehouse');
    Route::get('gudang.premixwarehouse','GudangController@premixwarehouse')->name('premixwarehouse');
    Route::get('gudang.gudangcabang','GudangController@gudangcabang')->name('gudangcabang');
    Route::get('purchase.returns','PurchaseController@tampilreturn')->name('returnbarang');
    Route::get('purchase.purchin','PurchaseController@purchasein')->name('purchin');
    Route::get('purchase.purchpremix','PurchaseController@purchpremix')->name('purchpremix');
    Route::get('purchase/{id}/lihat','PurchaseController@lihat')->name('lihat');
    Route::get('purchase/{id}/lihatin','PurchaseController@lihatin')->name('lihatin');
    Route::get('receive/{id}/detailreturn','ReceiveController@detailreturn')->name('detailreturn');
    Route::get('purchase/{id}/detailbayar','PurchaseController@detailbayar')->name('detailbayar');
    Route::get('purchase/{id}/detailbayarin','PurchaseController@detailbayarin')->name('detailbayarin');
    Route::get('receive/{id}/detailbayar','ReceiveController@detailbayar')->name('detailbayarbarang');
    Route::get('peminjaman/tocabang','GudangCabangController@tocabang')->name('tocabang');
    Route::get('receive/{id}/print','ReceiveController@print')->name('printrec');
    Route::get('purchase/{id}/print','PurchaseController@print')->name('printpur');
    Route::get('payment/{id}/print','PurchaseController@printpaid')->name('paid');
    Route::get('purprod/{id}/bayarprod','PurchaseController@bayarprod')->name('bayarprod');
    Route::get('purprod/{id}/detailbayarprod','PurchaseController@detailpayprod')->name('detailbayarprod');
    Route::post('purprod/inputbayarprod','PurchaseController@inputbayarprod')->name('inputbayarprod');
    Route::get('payprod/{id}/print','PurchaseController@printprod')->name('printprod');
    Route::get('purchase.createbig','PurchaseController@createbig')->name('createbig');
    Route::post('purchase/storebig','PurchaseController@storebig')->name('storebig');
    
    Route::get('peminjaman/{id}/print','GudangCabangController@printpeminjaman')->name('printpin');
    Route::get('purchase/{id}/bayar','PurchaseController@bayar')->name('bayar');
    Route::get('warehouse.potongan','WarehouseController@potongan')->name('potongan');
    Route::post('warehouse.inputpotongan','WarehouseController@input_potongan')->name('input_potongan');
    Route::get('warehouse.potonganinput','WarehouseController@form_potongan')->name('form_potongan');
    Route::get('peminjaman/{id}/bayar','GudangCabangController@formbayar')->name('formbayar');
    
    Route::get('receive.return2','ReceiveController@datareturnsupplier2')->name('datareturnsuppliers2');
    Route::get('receive.return','ReceiveController@datareturnsupplier')->name('datareturnsuppliers');
    Route::get('receive.returnsupplier','ReceiveController@returnsupplier')->name('returnsupplier');
    Route::post('receive/inputreturn','ReceiveController@inputreturn')->name('inputreturn');
    Route::post('gudangcabang/pinjaman','GudangCabangController@pinjaman')->name('inputpinjam');
    Route::post('purchase/bayar','PurchaseController@inputbayar')->name('inputbayar');
    Route::post('pinjaman/bayar','GudangCabangController@inputbayar')->name('inputbayarhutang');
    Route::get('peminjaman/{id}/detail','GudangCabangController@detailbayar')->name('detailbayarhutang');
    Route::get('peminjaman/{id}/detailbayarcabang','GudangCabangController@detailbayartocabang')->name('detailbayarcabang');
    Route::get('peminjaman/{id}/detailtocabang','GudangCabangController@detailtocabang')->name('detailtocabang');
    Route::post('receive/bayar','ReceiveController@inputbayarbarangmasuk')->name('ibm');
    Route::get('receive/{id}/receivebayar','ReceiveController@inputbayar')->name('receivebayar');
    Route::get('detail/{id}/edit','GudangCabangController@editqty')->name('editqtypinjam');
    Route::patch('detail/{id}/edit','GudangCabangController@aksieditqty')->name('aksipinjam'); 
    
    Route::get('detail/{id}/edit','PurchaseController@editqty')->name('editqty');
    Route::patch('detail/{id}/edit','PurchaseController@aksieditqty')->name('aksi');
    Route::patch('detail/{id}/receive','PurchaseController@receive')->name('receive'); 
    Route::get('detail/{id}/approval','PurchaseController@approval')->name('approval');
    Route::get('detail/{id}/setujui','GudangCabangController@setujui')->name('setujui');
    Route::get('detail/{id}/tidaktersedia','PurchaseController@tidaktersedia')->name('tidaktersedia');
    Route::get('detail/{id}/ditolak','GudangCabangController@ditolak')->name('ditolak');
    Route::get('detail/{id}/tostok','GudangCabangController@tostok')->name('tostokpinjam'); 
    
    Route::get('detail/{id}/tostok','PurchaseController@tostok')->name('tostok');
    Route::get('detail/{id}/tostokpremixes','PurchaseController@tostokpremixes')->name('tostokpremixes');   
    Route::get('detail/{id}/tostok','PurchaseController@tostok')->name('tostok');  
    Route::get('detail/{id}/instok','ReceiveController@instok')->name('instok');  
    Route::get('detail/{id}/receive','PurchaseController@receive')->name('receive');
    Route::get('detail/{id}/restok','PurchaseController@restok')->name('restok');
    Route::get('detail/{id}/return','PurchaseController@return')->name('return');
    Route::get('provinces', 'KasirController@provinces')->name('provinces');
    Route::get('kasir.getKecamatan', 'TransaksiController@getKecamatan');
    Route::get('kasir.getDesa', 'TransaksiController@getDesa');


    

    //
    // Route::get('image-upload', 'UserController@imageUpload')->name('image.upload');
    // Route::post('image-upload', 'UserController@imageUploadPost')->name('image.upload.post');



Route::group(['middleware' => ['chiefstore']], function () {
    Route::post('chiefstore/chartpenyebab','ChiefstoreController@chartpenyebab')->name('chiefstore.chartpenyebab');
    Route::post('chiefstore/chartakibat','ChiefstoreController@chartakibat')->name('chiefstore.chartakibat');
    Route::post('chiefstore/getpercabang','ChiefstoreController@getpercabang')->name('chiefstore.getcabang');
    Route::get('chiefstore/open','ChiefstoreController@open')->name('chiefstore.open');
    Route::get('chiefstore/approve','ChiefstoreController@approveshow')->name('chiefstore.approveshow');
    Route::get('chiefstore/reject','ChiefstoreController@rejectedshow')->name('chiefstore.rejectedshow');
    Route::get('chiefstore/close','ChiefstoreController@close')->name('chiefstore.close');
    Route::resource('chiefstore', 'ChiefstoreController');
    Route::get('chiefstore/{id}/approve','ChiefstoreController@approve')->name('chiefstore.approve');
    Route::patch('chiefstore/{id}/rejected','ChiefstoreController@rejected')->name('user.rejected');

});

Route::group(['middleware' => ['helpdesk']], function () {
    Route::get('helpdesk/open','HelpdeskController@open')->name('helpdesk.open');
    Route::get('helpdesk/approve','HelpdeskController@approveshow')->name('helpdesk.approveshow');
    Route::get('helpdesk/reject','HelpdeskController@rejectedshow')->name('helpdesk.rejectedshow');
    Route::get('helpdesk/close','HelpdeskController@close')->name('helpdesk.close');
    Route::get('helpdesk/exportall','HelpdeskController@exportall')->name('helpdesk.exportall');
    Route::get('helpdesk/exportsolved','HelpdeskController@exportsolved')->name('helpdesk.exportsolved');
    Route::get('helpdesk/exportclose','HelpdeskController@exportclose')->name('helpdesk.exportclose');
    Route::get('helpdesk/{id}/print','HelpdeskController@print')->name('helpdesk.print');
    Route::resource('helpdesk', 'HelpdeskController');
    Route::patch('helpdesk/{id}/solved','HelpdeskController@solved')->name('helpdesk.solved');
    Route::patch('helpdesk/{id}/rejected','HelpdeskController@rejected')->name('helpdesk.rejected');
    Route::get('helpdesk/{id}/forward','HelpdeskController@forward')->name('helpdesk.forward');
    Route::get('helpdesk/{id}/forwardrnd','HelpdeskController@forwardrnd')->name('helpdesk.forwardrnd');
    //update 06012020
    Route::get('helpdesk/{id}/forwardfinance','HelpdeskController@forwardfinance')->name('helpdesk.forwardfinance');
    Route::get('helpdesk/{id}/proseshelpdesk','HelpdeskController@proseshelpdesk')->name('helpdesk.proseshelpdesk');
    Route::get('helpdesk/{id}/unproseshelpdesk','HelpdeskController@unproseshelpdesk')->name('helpdesk.unproseshelpdesk');
    Route::get('helpdesk/{id}/forwardsupplychain','HelpdeskController@forwardsupplychain')->name('helpdesk.forwardsupplychain');

    Route::resource('akun', 'AkunController');
    Route::get('akun/{id}/aktifuser','AkunController@aktifuser')->name('akun.aktifuser');
    Route::get('akun/{id}/nonaktifuser','AkunController@nonaktifuser')->name('akun.nonaktifuser');
    
    Route::resource('penyebab', 'PenyebabController');
    Route::resource('akibat', 'AkibatController');
    Route::post('getpercabang','HelpdeskController@getpercabang')->name('getcabang');

});

Route::group(['middleware' => ['infra'] ], function () {
    Route::resource('infra', 'InfraController');
    Route::patch('infra/{id}/solved','InfraController@solved')->name('infra.solved');
    Route::patch('infra/{id}/rejected','InfraController@rejected')->name('infra.rejected');
    Route::get('infra/{id}/forwardfinance','InfraController@forwardfinance')->name('infra.forwardfinance');
    Route::get('infra/{id}/forwardrnd','InfraController@forwardrnd')->name('infra.forwardrnd');
    Route::get('infra/{id}/forwardsupplychain','InfraController@forwardsupplychain')->name('infra.forwardsupplychain');
    Route::get('infra/{id}/prosesinfra','InfraController@prosesinfra')->name('infra.prosesinfra');
    Route::get('infra/{id}/unprosesinfra','InfraController@unprosesinfra')->name('infra.unprosesinfra');

});
Route::group(['middleware' => ['rnd'] ], function () {
    Route::resource('rnd', 'RndController');
    Route::patch('rnd/{id}/solved','RndController@solved')->name('rnd.solved');
    Route::patch('rnd/{id}/rejected','RndController@rejected')->name('rnd.rejected');
    Route::get('rnd/{id}/forwardfinance','RndController@forwardfinance')->name('rnd.forwardfinance');
    Route::get('rnd/{id}/forwardsupplychain','RndController@forwardsupplychain')->name('rnd.forwardsupplychain');
    Route::get('rnd/{id}/prosesrnd','RndController@prosesrnd')->name('rnd.prosesrnd');
    Route::get('rnd/{id}/unprosesrnd','RndController@unprosesrnd')->name('rnd.unprosesrnd');


});
Route::group(['middleware' => ['finance'] ], function () {
    Route::resource('finance', 'FinanceController');
    Route::patch('finance/{id}/solved','FinanceController@solved')->name('finance.solved');
    Route::patch('finance/{id}/rejected','FinanceController@rejected')->name('finance.rejected');
    Route::get('finance/{id}/forwardrnd','FinanceController@forwardrnd')->name('finance.forwardrnd');
    Route::get('finance/{id}/forwardhelpdesk','FinanceController@forwardhelpdesk')->name('finance.forwardfinance');
    Route::get('finance/{id}/forwardsupplychain','FinanceController@forwardsupplychain')->name('finance.forwardsupplychain');
    Route::get('finance/{id}/prosesfinance','FinanceController@prosesfinance')->name('finance.prosesfinance');
    Route::get('finance/{id}/unprosesfinance','FinanceController@unprosesfinance')->name('finance.unprosesfinance');

});
Route::group(['middleware' => ['supplychain'] ], function () {
    Route::resource('supplychain', 'SupplychainController');
    Route::patch('supplychain/{id}/solved','SupplychainController@solved')->name('supplychain.solved');
    Route::patch('supplychain/{id}/rejected','SupplychainController@rejected')->name('supplychain.rejected');
    Route::get('supplychain/{id}/forwardrnd','SupplychainController@forwardrnd')->name('supplychain.forwardrnd');
    Route::get('supplychain/{id}/forwardfinance','SupplychainController@forwardfinance')->name('supplychain.forwardfinance');
    Route::get('supplychain/{id}/forwardhelpdesk','SupplychainController@forwardhelpdesk')->name('supplychain.forwardsupplychain');
    Route::get('supplychain/{id}/prosessupply','SupplychainController@prosessupply')->name('supplychain.prosessupply');
    Route::get('supplychain/{id}/unprosessupply','SupplychainController@unprosessupply')->name('supplychain.unprosessupply');

});







Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
