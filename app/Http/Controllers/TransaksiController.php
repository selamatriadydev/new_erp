<?php

namespace App\Http\Controllers;

use App\CartModel;
use App\CekoutModel;
use App\CabangModel;
use App\PaketModel;
use App\Provinces;
use App\Regencies;
use App\Districts;
use App\Villages;
use App\CartItem;
use App\PelunasanOrder;
use App\PengeluaranGudangModel;
use App\Order;
use App\DetailOrder;
use App\ReturnRetail;
use App\BonusRetail;
use App\DetailRetail;
use App\ItemOrder;
use App\ItemModel;
use App\IntiKomponenModel;
use App\KomponenModel;
use App\StokRetailModel;
use App\PengeluaranBahan;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transaksi/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

 public function our_backup_database(){

        //ENTER THE RELEVANT INFO BELOW
        $mysqlHostName      = env('DB_HOST');
        $mysqlUserName      = env('DB_USERNAME');
        $mysqlPassword      = env('DB_PASSWORD');
        $DbName             = env('DB_DATABASE');
        $backup_name        = "mybackup.sql";
        $tables             = array("orders","detail_orders","paket_models","item_orders"); //here your tables...

        $connect = new \PDO("mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword",array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $statement->execute();
        $result = $statement->fetchAll();


        $output = '';
        foreach($tables as $table)
        {
         $show_table_query = "SHOW CREATE TABLE " . $table . "";
         $statement = $connect->prepare($show_table_query);
         $statement->execute();
         $show_table_result = $statement->fetchAll();

         foreach($show_table_result as $show_table_row)
         {
          $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
         }
         $select_query = "SELECT * FROM " . $table . "";
         $statement = $connect->prepare($select_query);
         $statement->execute();
         $total_row = $statement->rowCount();

         for($count=0; $count<$total_row; $count++)
         {
          $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
          $table_column_array = array_keys($single_result);
          $table_value_array = array_values($single_result);
          $output .= "\nINSERT INTO $table (";
          $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
          $output .= "'" . implode("','", $table_value_array) . "');\n";
         }
        }
        $file_name = 'database_backup_on_' . date('y-m-d') . '.sql';
        $file_handle = fopen($file_name, 'w+');
        fwrite($file_handle, $output);
        fclose($file_handle);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
           header('Pragma: public');
           header('Content-Length: ' . filesize($file_name));
           ob_clean();
           flush();
           readfile($file_name);
           unlink($file_name);
    }
    public function addtocart(Request $request)
    {
        $aut = Auth::user()->cabang_id;
        $user = Auth::user()->id;
        $id = $request->id;
        $idkom = $request->code_komponen;
        $no_invoice = $request->no_invoice;
        $qty = $request->qty;
        // dd($qty);
        if($request->jenis_paket == "Khusus"){
            $id_paket = $request->id;
            $request->validate([
                'addmore.*.id_item' => 'required'
            ]);
            // dd($id_paket);
            foreach ($request->addmore as $key => $value) {
                $test = $request->addmore;
                $hpps =  ItemModel::where('id',$test)->sum('hpp');
                // dd($hpps);
                $jual =  ItemModel::where('id',$value)->sum('harga_jual');
                CartItem::create([
                    'id_paket'  => $id_paket,
                    'id_item'   => $value['id_item'],
                    'id_user'   => Auth::user()->id, 
                    'hpp'       => $hpps,
                    'harga'     => $jual,  
                    'cabang_id' => $aut,
                    'qty'       => $qty,
                    'subhpp'    => $qty*$hpps,
                    'subtotal'  => $qty*$jual
                    
                ]);
            //    dd($request->addmmore);
            }
        }
        elseif($request->jenis_paket = "Biasa"){
             $idkom = $request->code_komponen;
            $komponen = KomponenModel::where('code_komponen',$idkom)
            ->get();
            // dd($komponen);
            foreach($komponen as $kk){
                $idtem  = $kk->id_item;
                $hargaspk = $kk->hpp;
                $hargasju = $kk->harga_jual;
           
          
            $input = new CartItem();
            // $input->no_invoice = $no_invoice;
            $input->id_paket = $id;
            $input->cabang_id  = Auth::user()->cabang_id;
            $input->id_user    = Auth::user()->id;
            $input->id_item    = $kk->id_item;
            $hpps =  $hargaspk; 
            $juals =  $hargasju;
            // dd($juals);
            $qty = $request->qty;
            $subhpps = $hpps*$qty;
            $subtotal = $juals*$qty;
            // dd($juals);
            $input->hpp         = $hpps;
            $input->harga       = $juals;
            $input->qty         = $qty;
            $input->subhpp      = $subhpps;
            $input->subtotal    = $subtotal;
            $input->save();
            }
            //   dd($komponen);
           
            
        }
        $harga_pok = CartItem::where('id_paket',$id)->where('id_user',$user)->sum('hpp');
        
        $harju = CartItem::where('id_paket',$id)->where('id_user',$user)->sum('harga');
        // dd($harju);
        $hpp = $harga_pok;
        if($request->jenis_paket == "Biasa")
        {
            $pakets = PaketModel::where('code_komponen',$idkom)->get();
            foreach($pakets as $pakzx){
                $harga = $pakzx->harga_jual;
            }
        }
        elseif($request->jenis_paket == "Khusus")
        {
              $harga = $harju;
        }
        else{
            
        }
        
      
        
        $discount = $request->disc;
        $cutsale  = $request->cut_sale;
        $hitungs= $hpp*$qty;
        $hitung1= $harga*$qty;
        $cutsales =  $qty * $cutsale;
       
       
        

        if($discount > 0){
            $discounts = $hitung1 * ($discount/100);
            $subtotal = $hitung1 - $discounts;
            $subhpp = $hitungs - $discounts;
        }
        elseif($cutsale > 0){
            $subtotal = $hitung1 - $cutsales;
            $subhpp = $hitung1 - $cutsales;
           
        }
        else{
            $subtotal = $hitung1;
            $subhpp = $hitungs;
           
        }
        $cek = CartModel::where('id_paket',$id)->where('id_user',$user)->where('cabang_id',$aut)->count();
        
        if($cek){
            
            if($discount > 0){
                $input = CartModel::where('id_paket',$id)->where('id_user',$user)->update([
                    'qty' => DB::raw("qty + $qty"),'subhpp' => DB::raw("(hpp * qty) - $discounts"),'disc' => $discounts,'subtotal' => DB::raw("(harga * qty) - $discounts"),'disc' => DB::raw("$discount")
                ]);
                // $itemorder = ItemOrder::where('id_paket',$id)->update([
                //     'qty' => DB::raw("qty + $qty") 
                // ]);
            }
            elseif($cutsale > 0){
                $input = CartModel::where('id_paket',$id)->where('id_user',$user)->update([
                    'qty' => DB::raw("qty + $qty"),'subhpp' => DB::raw("(hpp * qty) - $cutsales"),'subtotal' => DB::raw("(harga * qty) - (qty * $cutsale)"),'cut_sale' => DB::raw("$cutsale")
                ]);
                // $itemorder = ItemOrder::where('id_paket',$id)->update([
                //     'qty' => DB::raw("qty + $qty") 
                // ]);
            }
            else{
                $input = CartModel::where('id_paket',$id)->where('id_user',$user)->update(['qty' => DB::raw("qty + $qty"),
                    'subhpp' => DB::raw("hpp * qty"),'subtotal' => DB::raw("harga * qty"),
                ]);
                // $itemorder = ItemOrder::where('id_paket',$id)->update([
                //     'qty' => DB::raw("qty + $qty") 
                // ]);
            }

        }
        else{
            if($discount > 0){
                $masukan = CartModel::insert(['id_paket'=>$id,'hpp'=>$hpp,'harga'=>$harga,'qty'=>$qty,'disc'=>$discount,'cut_sale'=>$cutsales,'subhpp'=>$subhpp,'subtotal'=>$subtotal,'cabang_id'=>$aut,'id_user'=>$user]);

            }
            elseif($cutsale > 0){
                $masukan = CartModel::insert(['id_paket'=>$id,'hpp'=>$hpp,'harga'=>$harga,'qty'=>$qty,'disc'=>$discount,'cut_sale'=>$cutsale,'subhpp'=>$subhpp,'subtotal'=>$subtotal,'cabang_id'=>$aut,'id_user'=>$user]);
            
            }
            else{
                $masukan = CartModel::insert(['id_paket'=>$id,'hpp'=>$hpp,'harga'=>$harga,'qty'=>$qty,'disc'=>$discount,'cut_sale'=>$cutsale,'subhpp'=>$qty*$hpp,'subtotal'=>$qty*$harga,'cabang_id'=>$aut,'id_user'=>$user]);
            // dd($hpp);
                
            }
          
        }
    

        return back()->with('succes','Product Masuk Keranjang');
    }

    public function cekoutnew(Request $request){

        $user = Auth::user()->id;
        $cabangs = Auth::user()->cabang_id;
        $cabang = CabangModel::all();
        $cart = CartModel::join('paket_models','cart.id_paket','paket_models.id')
        ->where('cart.cabang_id',$cabangs)
        ->where('cart.id_user',$user)
        ->select('cart.id',
                'paket_models.nama_paket',
                'cart.qty',
                'cart.hpp',
                'cart.harga',
                'cart.disc',
                'cart.cut_sale',
                'cart.subhpp',
                'cart.subtotal',
                'cart.cabang_id',
                'cart.id_user')
                ->get();
        $bighpp = CartModel::where('id_user',$user)->where('cabang_id',$cabangs)->sum('subhpp');
        $big = CartModel::where('id_user',$user)->where('cabang_id',$cabangs)->sum('subtotal');
        $no_invoice = $request->no_invoice;
        $bayar = $request->bayar;
        $provinces = Provinces::pluck('name', 'id');
        $reg = Regencies::where('id','=',"3325")->get();
        $dis = Districts::where('regency_id','=',"3325")->get();
        $from  = "33";
        $to   = "34";
        $vill = Villages::whereBetween('district_id', [$from, $to])->get();
        // dd($reg);
        // dd($bayar);
        $kabupaten = Regencies::whereBetween('province_id', [$from, $to])->get();;
        return view('kasir/cekoutnew',compact('cart','no_invoice','big','bighpp','bayar','cabang','cabangs','reg','dis','vill','kabupaten'));
    }
    
    public function getKecamatan(Request $request){
        $kecamatan = Districts::where("regency_id",$request->kabID)->pluck('id','name');
        return response()->json($kecamatan);
    }
    public function getDesa(Request $request){
        $desa = Villages::where("district_id",$request->kecID)->pluck('id','name');
        return response()->json($desa);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function invoice(Request $request){
        $idcabang = Auth::user()->cabang_id;
        $iduser =  Auth::user()->id;
        $invoice = $request->no_invoice;
        $jeniscust = $request->jeniscust;
        $namacust = $request->cust;
        $telp = $request->telp;
        $jenisorder =  $request->jenisorder;
        $tanggal = $request->tanggal;
        $jam = $request->jam;
        $kota  = $request->kabupaten;
        $kec = $request->kecamatan;
        $kel = $request->desa;
        $jln = $request->jalan;
        $patokan = $request->patokan;
        $bighpp = $request->bighpp;
        $bigtotal = $request->bigtotal;
        $bayar = $request->bayar;
        $sisa = $request->sisa;
        $keterangan =  $request->keterangan;
        $status = "Masuk";
        $cart = CartModel::where('id_user',$iduser)->get();
        $cek = DetailOrder::where('user_id',$iduser)->where('cabang_id',$idcabang)->where('no_invoice',$invoice)->count();
        // dd($cart);
        foreach($cart as $c){
        $id = $c->id;
        $idpaket = $c->id_paket;
        $qty = $c->qty;
        $hpp = $c->hpp;
        $harga = $c->harga;
        $disc = $c->disc;
        $cutsale = $c->cut_sale;
        // dd($cutsale);
        $subhpp = $c->subhpp;
        $subtotal = $c->subtotal;
        $cabangid = $c->cabang_id;
        $iduser = $c->id_user;  
        $cartitem  = CartItem::where('id_user',$iduser)->get();
        // dd($cartitem);
        foreach($cartitem as $cartis){
            $paks = $cartis->id_paket;
            $cabangss = Auth::user()->cabang_id;
            $id_itemss =  $cartis->id_item;
            $quan = $cartis->qty;
            $cakkaap = ItemOrder::where('id_paket',$paks)->where('id_item',$id_itemss)->where('no_invoice',$invoice)->count();
            if($cakkaap){

            }
            else{
                $mleb = new ItemOrder();
                $mleb->no_invoice = $invoice;
                $mleb->id_paket   = $paks;
                $mleb->cabang_id  = $cabangss;
                $mleb->id_item    = $id_itemss;
                $mleb->qty        = $quan;
                $mleb->status     = "Masuk";
                $mleb->save();
            }
        
        }
        
        if($cek){

        }
        else{
            $input = new DetailOrder();
            $input->no_invoice = $invoice ;
            $input->cabang_id = $idcabang ;
            $input->user_id = $iduser;
            $input->id_paket = $idpaket;
            $input->hpp = $hpp;
            $input->harga = $harga;
            // dd($harga);
            $input->qty = $qty;
            $input->disc = $disc;
            $input->cutsale = $cutsale;
            $input->subhpp = $subhpp;
            $input->subtotal = $subtotal;
            $input->tanggal_kirim = $tanggal;
            $input->jam_kirim = $jam;
            $input->status = $status;
            $input->save();


            
        }
    }
        $cek2 = Order::where('no_invoice',$invoice)->where('user_id',$iduser)->where('cabang_id',$idcabang)->count();
        if($cek2){

        }
        else{
            $input = new Order();
            $input->cabang_id = $idcabang;
            $input->user_id = Auth::user()->id;
            $input->no_invoice = $invoice;
            $input->nama_cust = $namacust;
            $input->jenis_cust = $jeniscust;
            $input->jenis_order = $jenisorder;
            $input->tanggal_masuk = date('Y-m-d');
            $input->tanggal_kirim = $tanggal;
            $input->jam_kirim = $jam;
            $input->no_telp = $telp;
            $input->id_kota = $kota;
            $input->id_kec = $kec;
            $input->id_keluaran = $kel;
            $input->jalan = $jln;
            $input->patokan = $patokan;
            $input->bighpp = $bighpp;
            $input->bigtotal = $bigtotal;
            $input->bayar = $bayar;
            $input->sisa = $sisa;
            $input->status = $status;
            $input->keterangan = $keterangan;
            $input->save(); 
        }
        $namacabang = CabangModel::where('id',$idcabang)->select('nama_cabang','no_hp')->get();
        $nota = Order::where('user_id',$iduser)->where('no_invoice',$invoice)
        ->join('users','orders.user_id','users.id')
        ->join('cabang','orders.cabang_id','cabang.id')
        ->join('regencies','orders.id_kota','regencies.id')
        ->join('districts','orders.id_kec','districts.id')
        ->join('villages','orders.id_keluaran','villages.id')
        ->select('orders.no_invoice',
        'orders.nama_cust',
        'orders.jenis_cust',
        'cabang.nama_cabang',
        'users.name',
        'orders.tanggal_kirim',
        'orders.jam_kirim',
        'orders.no_telp',
        'orders.jenis_order',
        'regencies.name as kota',
        'districts.name as kec',
        'villages.name as kel',
        'orders.jalan',
        'orders.patokan',
        'orders.bigtotal',
        'orders.bayar',
        'orders.sisa',
        'orders.status',
        'orders.keterangan')
        ->get();
        $detail = DetailOrder::where('detail_orders.no_invoice',$invoice)
        ->join('paket_models','detail_orders.id_paket','paket_models.id')
        ->join('orders','detail_orders.no_invoice','orders.no_invoice')
        // ->join('item_orders','detail_orders.no_invoice','item_orders.no_invoice')
        // ->join('item_models','item_orders.id_item','item_models.id')
        // ->where('detail_orders.status','=','Selesai')
        ->select(
                'detail_orders.id',
                'orders.no_invoice',
                'orders.nama_cust',
                'paket_models.nama_paket',
                'detail_orders.qty',
                'orders.tanggal_kirim',
                'orders.jam_kirim',
                'detail_orders.harga',
                'detail_orders.disc',
                'detail_orders.cutsale',
                'detail_orders.subtotal')
            // ->groupby('orders.no_invoice','paket_models.nama_paket','orders.tanggal_kirim',
            // 'orders.jam_kirim','orders.nama_cust','detail_orders.qty','detail_orders.harga','detail_orders.subtotal')
            ->orderby('orders.tanggal_kirim','asc')
            ->orderby('orders.jam_kirim','asc')


        ->get();
        // ->join('paket_models','detail_orders.id_paket','paket_models.id')
        // ->join('komponen_models','paket_models.code_komponen','komponen_models.code_komponen')
        // ->join('orders','detail_orders.no_invoice','orders.no_invoice')
        // ->join('item_models','komponen_models.id_item','item_models.id')
        // ->where('detail_orders.cabang_id',$id_cabang)
        // ->where('detail_orders.status','=','Selesai')
        // ->select(
        //         // 'detail_orders.id',
        //         // 'item_models.nama_item',
        //         'detail_orders.no_invoice',
        //         'orders.nama_cust',
        //         'paket_models.nama_paket',
        //         'detail_orders.qty',
        //         'orders.tanggal_kirim',
        //         'orders.jam_kirim',
        //         // 'orders.status',
        //         DB::raw('GROUP_CONCAT(item_models.nama_item) as items'))
        //     ->groupby('detail_orders.no_invoice','paket_models.nama_paket','orders.tanggal_kirim',
        //     'orders.jam_kirim','orders.nama_cust','detail_orders.qty')
        //     ->orderby('orders.tanggal_kirim','asc')
        //     ->orderby('orders.jam_kirim')


        // ->get();
        // dd($detail);
        $hapus = CartModel::where('id_user',$iduser)->delete();
        $hapus = CartItem::where('id_user',$iduser)->delete();

        return view('kasir/print',compact('detail','hapus','nota','namacabang'));

    }

    public function dataorder(Request $request){
        $id_cabang = Auth::user()->cabang_id;
        $now = date('Y-m-d');
        $order = Order::join('users','orders.user_id','users.id')
        ->join('cabang','orders.cabang_id','cabang.id')
        ->join('regencies','orders.id_kota','regencies.id')
        ->join('districts','orders.id_kec','districts.id')
        ->join('villages','orders.id_keluaran','villages.id')
        ->where('orders.tanggal_masuk',$now)
        ->where('orders.cabang_id',$id_cabang)
        ->select('orders.id','orders.no_invoice',
        'orders.nama_cust',
        'cabang.nama_cabang',
        'users.name',
        'orders.tanggal_kirim',
        'orders.tanggal_masuk',
        'orders.jam_kirim',
        'orders.no_telp',
        'orders.jenis_order',
        'regencies.name as kota',
        'districts.name as kec',
        'villages.name as kel',
        'orders.jalan',
        'orders.patokan',
        'orders.bigtotal',
        'orders.bayar',
        'orders.sisa',
        'orders.status',
        'orders.alasan')
        // ->where('orders.tanggal_masuk','=',"2022-03-13")
        ->orderBy('tanggal_masuk','desc')
        ->get();
        $big = Order::where('orders.cabang_id',$id_cabang)
        ->where('tanggal_masuk',$now)
        ->where('status','!=',"Cancel")
        ->sum('bigtotal');
        $pay = Order::where('orders.cabang_id',$id_cabang)
        ->where('tanggal_masuk',$now)
        ->where('status','!=',"Cancel")
        ->sum('bayar');
        $cha = Order::where('orders.cabang_id',$id_cabang)
        ->where('tanggal_masuk',$now)
        ->where('status','!=',"Cancel")
        ->sum('sisa');
        // dd($order);
        return view('order/data',compact('id_cabang','order','big','pay','cha','now'));
    }
     public function laporan(){

        return view('order/laporan');
    }
    public function filterlaporanorder(Request $request){
        $cabang = Auth::user()->cabang_id;
        $namacabang = CabangModel::where('id',$cabang)->get();
        $hak    = Auth::user()->hak_akses;
        $user   = Auth::user()->id;
        $cek = $request->datetimes;
        $string = explode('-',$cek);

        $date1 = explode('/',$string[0]);
        $date2 = explode('/',$string[1]);

        $finalDate1 = $date1[0].'-'.$date1[1].'-'.$date1[2];
        $finalDate2 = $date2[0].'-'.$date2[1].'-'.$date2[2];
        $bigtotal = Order::whereBetween('tanggal_masuk',[$finalDate1, $finalDate2])->where('orders.user_id',$user)->where('cabang_id',$cabang)->where('status','!=',"Cancel")->sum('bigtotal');
        $bayar = Order::whereBetween('tanggal_masuk',[$finalDate1, $finalDate2])->where('orders.user_id',$user)->where('cabang_id',$cabang)->where('status','!=',"Cancel")->sum('bayar');
        $return = ReturnRetail::whereBetween('tanggal_return',[$finalDate1, $finalDate2])->where('cabang_id',$cabang)->where('user_id',$user)->sum('subtotal_up');
        $bonus = BonusRetail::whereBetween('tanggal_keluar',[$finalDate1, $finalDate2])->where('cabang_id',$cabang)->where('user_id',$user)->sum('subtotal_up'); 
        $bighpp = Order::whereBetween('tanggal_masuk',[$finalDate1, $finalDate2])->where('orders.user_id',$user)->where('cabang_id',$cabang)->where('status','!=',"Cancel")->sum('bighpp');
        $pelunasan = PelunasanOrder::whereBetween('tanggal_masuk',[$finalDate1, $finalDate2])->where('user_id',$user)->where('cabang_id',$cabang)->sum('nominal');
        $pengeluaran = PengeluaranGudangModel::join('jenis_pengeluaran_models','pengeluaran_gudang_models.id_guna','jenis_pengeluaran_models.id')
        ->whereBetween('pengeluaran_gudang_models.tanggal_pengeluaran',[$finalDate1, $finalDate2])
        ->where('pengeluaran_gudang_models.id_user',$user)
        ->where('pengeluaran_gudang_models.hak_akses',$hak)
        ->select('pengeluaran_gudang_models.id',
                'pengeluaran_gudang_models.total',
                'jenis_pengeluaran_models.nama_pengeluaran',
                'pengeluaran_gudang_models.nama_barang')
        ->get();
        $pensum = PengeluaranGudangModel::whereBetween('tanggal_pengeluaran',[$finalDate1, $finalDate2])
        ->where('pengeluaran_gudang_models.id_user',$user)
        ->where('pengeluaran_gudang_models.hak_akses',$hak)
        ->sum('total');
        $modal = DetailRetail::whereBetween('tanggal_transaksi',[$finalDate1, $finalDate2])->where('user_id',$user)->where('cabang_id',$cabang)->sum('subtotal_pk');
        
        $original = DetailRetail::join('item_models','detail_retails.code_item','item_models.code_item')->whereBetween('detail_retails.tanggal_transaksi',[$finalDate1, $finalDate2])->where('detail_retails.user_id',$user)->where('detail_retails.cabang_id',$cabang)->where('item_models.id_kategori','=',"1")->sum('detail_retails.subtotal_up');
        $umkmqu = DetailRetail::join('item_models','detail_retails.code_item','item_models.code_item')->whereBetween('detail_retails.tanggal_transaksi',[$finalDate1, $finalDate2])->where('detail_retails.user_id',$user)->where('detail_retails.cabang_id',$cabang)->where('item_models.id_kategori','=',"3")->sum('detail_retails.subtotal_up');
        $umkm = DetailRetail::join('item_models','detail_retails.code_item','item_models.code_item')->whereBetween('detail_retails.tanggal_transaksi',[$finalDate1, $finalDate2])->where('detail_retails.user_id',$user)->where('detail_retails.cabang_id',$cabang)->where('item_models.id_kategori','=',"2")->sum('detail_retails.subtotal_up');
       
        // dd($bayar);
        // dd($profit);
        $kureng = $pensum + $bighpp +$modal + $return + $bonus;
        return view('order/cetak',compact('umkmqu','umkm','namacabang','modal','original','kureng','pensum','pengeluaran','pelunasan','cek','finalDate1','finalDate2','string','date1','date2','bigtotal','bighpp','bayar','return','bonus'));
    }
    
    public function filterdataorder(Request $request){
        $cabang = Auth::user()->cabang_id;
        $hak    = Auth::user()->hak_akses;
        $user   = Auth::user()->id;
        $cek = $request->datetimes;
        $string = explode('-',$cek);

        $date1 = explode('/',$string[0]);
        $date2 = explode('/',$string[1]);

        $finalDate1 = $date1[0].'-'.$date1[1].'-'.$date1[2];
        $finalDate2 = $date2[0].'-'.$date2[1].'-'.$date2[2];
        
        $order = Order::join('users','orders.user_id','users.id')
        ->join('cabang','orders.cabang_id','cabang.id')
        ->join('regencies','orders.id_kota','regencies.id')
        ->join('districts','orders.id_kec','districts.id')
        ->join('villages','orders.id_keluaran','villages.id')
        ->whereBetween('orders.tanggal_masuk',[$finalDate1, $finalDate2])
        ->where('orders.user_id',$user)
        ->where('orders.cabang_id',$cabang)
        ->where('orders.status','!=',"Cancel")
        ->select('orders.id','orders.no_invoice',
        'orders.nama_cust',
        'cabang.nama_cabang',
        'users.name',
        'orders.tanggal_kirim',
        'orders.tanggal_masuk',
        'orders.jam_kirim',
        'orders.no_telp',
        'orders.jenis_order',
        'regencies.name as kota',
        'districts.name as kec',
        'villages.name as kel',
        'orders.jalan',
        'orders.patokan',
        'orders.bigtotal',
        'orders.bayar',
        'orders.sisa',
        'orders.status',
        'orders.alasan')
        ->orderBy('tanggal_kirim','desc')
        ->get();
        // dd($order);
        $bigtotal = Order::whereBetween('tanggal_masuk',[$finalDate1, $finalDate2])->where('orders.user_id',$user)->where('cabang_id',$cabang)->where('status','!=',"Cancel")->sum('bigtotal');
        $bayar = Order::whereBetween('tanggal_masuk',[$finalDate1, $finalDate2])->where('orders.user_id',$user)->where('cabang_id',$cabang)->where('status','!=',"Cancel")->sum('bayar');
        $sisa = Order::whereBetween('tanggal_masuk',[$finalDate1, $finalDate2])->where('orders.user_id',$user)->where('cabang_id',$cabang)->where('status','!=',"Cancel")->sum('sisa');
         return view('order/filterdata',compact('cabang','hak','user','cek','finalDate1','finalDate2','string','date1','date2','bigtotal','sisa','bayar','order'));
    }
    
     public function filterkirimorder(Request $request){
        $cabang = Auth::user()->cabang_id;
        $hak    = Auth::user()->hak_akses;
        $user   = Auth::user()->id;
        $cek = $request->datetimes;
        $string = explode('-',$cek);

        $date1 = explode('/',$string[0]);
        $date2 = explode('/',$string[1]);

        $finalDate1 = $date1[0].'-'.$date1[1].'-'.$date1[2];
        $finalDate2 = $date2[0].'-'.$date2[1].'-'.$date2[2];
        
        $order = Order::join('users','orders.user_id','users.id')
        ->join('cabang','orders.cabang_id','cabang.id')
        ->join('regencies','orders.id_kota','regencies.id')
        ->join('districts','orders.id_kec','districts.id')
        ->join('villages','orders.id_keluaran','villages.id')
        ->whereBetween('orders.tanggal_kirim',[$finalDate1, $finalDate2])
        ->where('orders.user_id',$user)
        ->where('orders.cabang_id',$cabang)
        ->where('orders.status','!=',"Cancel")
        ->select('orders.id','orders.no_invoice',
        'orders.nama_cust',
        'cabang.nama_cabang',
        'users.name',
        'orders.tanggal_kirim',
        'orders.tanggal_masuk',
        'orders.jam_kirim',
        'orders.no_telp',
        'orders.jenis_order',
        'regencies.name as kota',
        'districts.name as kec',
        'villages.name as kel',
        'orders.jalan',
        'orders.patokan',
        'orders.bigtotal',
        'orders.bayar',
        'orders.sisa',
        'orders.status',
        'orders.alasan')
        ->orderBy('tanggal_kirim','desc')
        ->get();
        // dd($order);
        $bigtotal = Order::whereBetween('tanggal_kirim',[$finalDate1, $finalDate2])->where('orders.user_id',$user)->where('cabang_id',$cabang)->where('status','!=',"Cancel")->sum('bigtotal');
        $bayar = Order::whereBetween('tanggal_kirim',[$finalDate1, $finalDate2])->where('orders.user_id',$user)->where('cabang_id',$cabang)->where('status','!=',"Cancel")->sum('bayar');
        $sisa = Order::whereBetween('tanggal_kirim',[$finalDate1, $finalDate2])->where('orders.user_id',$user)->where('cabang_id',$cabang)->where('status','!=',"Cancel")->sum('sisa');
         return view('order/kirimorder',compact('cabang','hak','user','cek','finalDate1','finalDate2','string','date1','date2','bigtotal','sisa','bayar','order'));
    }
    
    public function dataorderpacking(Request $request){
        $id_cabang = Auth::user()->cabang_id;
        $now = date('Y-m-d');
        // $order = DetailOrder::join('paket_models','detail_orders.id_paket','paket_models.id')
        // ->join('komponen_models','paket_models.code_komponen','komponen_models.code_komponen')
        // ->join('orders','detail_orders.no_invoice','orders.no_invoice')
        // ->join('item_models','komponen_models.id_item','item_models.id')
        // ->where('detail_orders.cabang_id',$id_cabang)
        // ->where('detail_orders.status','=','Selesai')
        // ->select(
        //         // 'detail_orders.id',
        //         // 'item_models.nama_item',
        //         'detail_orders.no_invoice',
        //         'orders.nama_cust',
        //         'paket_models.nama_paket',
        //         'detail_orders.qty',
        //         'orders.tanggal_kirim',
        //         'orders.jam_kirim',
        //         // 'orders.status',
        //         DB::raw('GROUP_CONCAT(item_models.nama_item) as items'))
        //     ->groupby('detail_orders.no_invoice','paket_models.nama_paket','orders.tanggal_kirim',
        //     'orders.jam_kirim','orders.nama_cust','detail_orders.qty')
        //     ->orderby('orders.tanggal_kirim','asc')
        //     ->orderby('orders.jam_kirim')


        // ->get();
            $order = ItemOrder::select('item_orders.no_invoice',
            'orders.nama_cust',
            'paket_models.nama_paket',
            'item_orders.qty',
            'orders.tanggal_kirim',
            'orders.jam_kirim',
            DB::raw('GROUP_CONCAT(item_models.nama_item) as items'))
            ->join('orders','item_orders.no_invoice','orders.no_invoice')
            ->leftjoin('paket_models','item_orders.id_paket','paket_models.id')
            ->join('item_models','item_orders.id_item','item_models.id')
            ->where('orders.cabang_id',$id_cabang)
            ->where('orders.tanggal_kirim',$now)
            ->where('orders.tanggal_masuk',$now)
            ->groupBy('item_orders.no_invoice','orders.nama_cust','item_orders.qty','paket_models.nama_paket','orders.tanggal_kirim',
            'orders.jam_kirim')
            ->orderBy('orders.tanggal_kirim','asc')
            ->orderBy('orders.jam_kirim','asc')
            ->get();
                                        //  dd($itemorder);
        
        // dd($order);

        return view('order/packing',compact('id_cabang','order','now'));
    }
    
    public function filterpacking(Request $request){
        $id_cabang = Auth::user()->cabang_id;
        $cek = $request->datetimes;
        $string = explode('-',$cek);

        $date1 = explode('/',$string[0]);
        $date2 = explode('/',$string[1]);

        $finalDate1 = $date1[0].'-'.$date1[1].'-'.$date1[2];
        $finalDate2 = $date2[0].'-'.$date2[1].'-'.$date2[2];
        
    $order = ItemOrder::select('item_orders.no_invoice',
            'orders.nama_cust',
            'paket_models.nama_paket',
            'item_orders.qty',
            'orders.tanggal_kirim',
            'orders.jam_kirim',
            DB::raw('GROUP_CONCAT(item_models.nama_item) as items'))
            ->join('orders','item_orders.no_invoice','orders.no_invoice')
            ->leftjoin('paket_models','item_orders.id_paket','paket_models.id')
            ->join('item_models','item_orders.id_item','item_models.id')
            ->whereBetween('orders.tanggal_kirim',[$finalDate1, $finalDate2])
            ->groupBy('item_orders.no_invoice','orders.nama_cust','item_orders.qty','paket_models.nama_paket','orders.tanggal_kirim',
            'orders.jam_kirim')
            ->OrderBy('orders.jam_kirim','asc')
            ->get();
            // dd($finalDate1);
          
    // dd($order);
        return view('order/filterpacking',compact('id_cabang','order','cek','finalDate1','finalDate2','string','date1','date2'));
    }
    public function dashboard(){
        $r =  DetailOrder::all();

        return view('dashboard/index',compact('r'));
    }
    public function dataprod(Request $request){
        $id_cabang = Auth::user()->cabang_id;
        $now = date('Y-m-d');
        $order = DetailOrder::join('paket_models','detail_orders.id_paket','paket_models.id')->
        join('orders','detail_orders.no_invoice','orders.no_invoice')
        ->where('detail_orders.cabang_id',$id_cabang)
        ->where('detail_orders.status','!=',"Selesai")
        ->where('detail_orders.status','!=',"Cancel")
        ->where('detail_orders.tanggal_kirim',$now)
        ->where('orders.tanggal_masuk',$now)
        ->select(
                'detail_orders.id',
                'detail_orders.no_invoice',
                'detail_orders.id_paket',
                'paket_models.nama_paket',
                'detail_orders.qty',
                'orders.tanggal_kirim',
                'orders.jam_kirim',
                'orders.status')
        ->OrderBy('detail_orders.status','asc')
        ->get();
        $big = Order::where('orders.cabang_id',$id_cabang)
        ->where('orders.status','!=',"Cancel")
        ->sum('bigtotal');
        $pay = Order::where('orders.cabang_id',$id_cabang)
        ->where('orders.status','!=',"Cancel")
        ->sum('bayar');
        $cha = Order::where('orders.cabang_id',$id_cabang)
        ->where('orders.status','!=',"Cancel")
        ->sum('sisa');
        // dd($order);
        return view('order/orderprod',compact('id_cabang','order','big','pay','cha','now'));
    }
    
    public function datapengeluaranbahanbaku(Request $request){
        $cabang = Auth::user()->cabang_id;
        $now = date('Y-m-d');
        $pengeluaran = DB::table('pengeluaran_bahans')
        ->join('barang_gudangs','pengeluaran_bahans.id_bahanbaku','barang_gudangs.id')
        ->join('satuan_models','pengeluaran_bahans.id_satuan','satuan_models.id')
        ->join('item_models','pengeluaran_bahans.id_item','item_models.id')
        ->where('pengeluaran_bahans.cabang_id',$cabang)
        ->where('pengeluaran_bahans.tanggal_produksi',$now)
        ->select('pengeluaran_bahans.id',
                'pengeluaran_bahans.no_invoice',
                'barang_gudangs.nama_barang',
                'item_models.nama_item',
                'satuan_models.nama_satuan',
                'pengeluaran_bahans.gramasi',
                'pengeluaran_bahans.total_harga',
                'pengeluaran_bahans.tanggal_produksi')
                ->get();
                $bigtotal = DB::table('pengeluaran_bahans')->where('cabang_id',$cabang)->where('tanggal_produksi',$now)->sum('total_harga');
                // dd($pengeluaran);
    return view('order/pengeluaranbahan',compact('cabang','pengeluaran','bigtotal'));
        
    }
    public function filterpengeluaranbahanbaku(Request $request){
        $cabang = Auth::user()->cabang_id;
        $cek = $request->datetimes;
        $string = explode('-',$cek);

        $date1 = explode('/',$string[0]);
        $date2 = explode('/',$string[1]);

        $finalDate1 = $date1[0].'-'.$date1[1].'-'.$date1[2];
        $finalDate2 = $date2[0].'-'.$date2[1].'-'.$date2[2];
        
        $pengeluaran = DB::table('pengeluaran_bahans')
        ->join('barang_gudangs','pengeluaran_bahans.id_bahanbaku','barang_gudangs.id')
        ->join('satuan_models','pengeluaran_bahans.id_satuan','satuan_models.id')
        ->join('item_models','pengeluaran_bahans.id_item','item_models.id')
        ->where('pengeluaran_bahans.cabang_id',$cabang)
        ->whereBetween('pengeluaran_bahans.tanggal_produksi',[$finalDate1, $finalDate2])
        ->select('pengeluaran_bahans.id',
                'pengeluaran_bahans.no_invoice',
                'barang_gudangs.nama_barang',
                'item_models.nama_item',
                'satuan_models.nama_satuan',
                'pengeluaran_bahans.gramasi',
                'pengeluaran_bahans.total_harga',
                'pengeluaran_bahans.tanggal_produksi')
                ->get();
                $bigtotal = DB::table('pengeluaran_bahans')->where('cabang_id',$cabang)->whereBetween('tanggal_produksi',[$finalDate1, $finalDate2])->sum('total_harga');
                // dd($pengeluaran);
    return view('order/pengeluaranbahan',compact('cabang','pengeluaran','bigtotal','cek','finalDate1','finalDate2','string','date1','date2'));
        
    }
     public function filterdataproduksi(Request $request){
        $id_cabang = Auth::user()->cabang_id;
        $cek = $request->datetimes;
        $string = explode('-',$cek);

        $date1 = explode('/',$string[0]);
        $date2 = explode('/',$string[1]);

        $finalDate1 = $date1[0].'-'.$date1[1].'-'.$date1[2];
        $finalDate2 = $date2[0].'-'.$date2[1].'-'.$date2[2];
        $order = DetailOrder::join('paket_models','detail_orders.id_paket','paket_models.id')->
        join('orders','detail_orders.no_invoice','orders.no_invoice')
        ->where('detail_orders.cabang_id',$id_cabang)
        ->where('detail_orders.status','!=',"Selesai")
        ->where('detail_orders.status','!=',"Cancel")
         ->whereBetween('detail_orders.tanggal_kirim',[$finalDate1, $finalDate2])
        ->select(
                'detail_orders.id',
                'detail_orders.no_invoice',
                'detail_orders.id_paket',
                'paket_models.nama_paket',
                'detail_orders.qty',
                'orders.tanggal_kirim',
                'orders.jam_kirim',
                'orders.status')
        ->OrderBy('detail_orders.status','asc')
        ->OrderBy('detail_orders.tanggal_kirim','asc')
        ->OrderBy('detail_orders.jam_kirim','asc')
        ->get();
        // dd($order);
        return view('order/orderprod',compact('id_cabang','order','cek','finalDate1','finalDate2','string','date1','date2'));
    }
    
     public function filterdatamasukproduksi(Request $request){
        $id_cabang = Auth::user()->cabang_id;
        $cek = $request->datetimes;
        $string = explode('-',$cek);

        $date1 = explode('/',$string[0]);
        $date2 = explode('/',$string[1]);

        $finalDate1 = $date1[0].'-'.$date1[1].'-'.$date1[2];
        $finalDate2 = $date2[0].'-'.$date2[1].'-'.$date2[2];
        $order = DetailOrder::join('paket_models','detail_orders.id_paket','paket_models.id')->
        join('orders','detail_orders.no_invoice','orders.no_invoice')
        ->where('detail_orders.cabang_id',$id_cabang)
        ->where('detail_orders.status','!=',"Selesai")
        ->where('detail_orders.status','!=',"Cancel")
         ->whereBetween('orders.tanggal_masuk',[$finalDate1, $finalDate2])
        ->select(
                'detail_orders.id',
                'detail_orders.no_invoice',
                'detail_orders.id_paket',
                'paket_models.nama_paket',
                'detail_orders.qty',
                'orders.tanggal_kirim',
                'orders.jam_kirim',
                'orders.status')
        ->OrderBy('detail_orders.status','asc')
        ->OrderBy('detail_orders.tanggal_kirim','asc')
        ->OrderBy('detail_orders.jam_kirim','asc')
        ->get();
        // dd($order);
        return view('order/orderprod',compact('id_cabang','order','cek','finalDate1','finalDate2','string','date1','date2'));
    }

    public function produksi(Request $request){
        $invoice = $request->invoice;
        $idpaket = $request->id_paket;
        $qty     = $request->qty;
        $order = Order::where('no_invoice',$invoice)->update([
            'status' => "Sedang diproduksi"
        ]);
        $detail = DetailOrder::where('no_invoice',$invoice)->update([
                'status' => "Sedang diproduksi"
            ]);

        $item = ItemOrder::where('no_invoice',$invoice)->update([
            'status' => "Sedang diproduksi"
        ]);
        // dd($detail);
        // $paket = PaketModel::where('id',$idpaket)->select('id_komponen')->get();
        // foreach($paket as $pakets){
        //     $idkom = $pakets->id_komponen;
        // }
        // $inti = IntiKomponenModel::where('id',$idkom)->get();
        // foreach($inti as $int){
        //     $nakom = $int->nama_komponen;
        // }
        // $komponen = KomponenModel::where('nama_komponen',$nakom)
        // ->get();
        
        // foreach($komponen as $kk){
        //     $id  = $kk->id_item;
       
        // // dd($id);
        // $input = new ItemOrder();
        // $input->no_invoice = $invoice;
        // $input->cabang_id  = Auth::user()->cabang_id;
        // $input->id_item    = $kk->id_item;
        // $input->qty        = $qty;
        // $input->status     = "Sedang diproduksi";
        // $input->save();
    
        return back()->with('succes','Product Masuk Keranjang');

    }
    public function cancel(Request $request){
        $invoice = $request->invoice;
        $alasan  = $request->alasan;
        $order = Order::where('no_invoice',$invoice)->update([
            'status' => "Cancel",
            'alasan' => $alasan
        ]);
        $detail = DetailOrder::where('no_invoice',$invoice)->update([
            'status' => "Cancel"
            
            ]);

        $item = ItemOrder::where('no_invoice',$invoice)->update([
            'status' => "Cancel"
        ]);
        
        return back()->with('succes','Product Masuk Keranjang');

    }

    public function dataitem(Request $request){
        $cabang = Auth::user()->cabang_id;
        $now = date('Y-m-d');
        $item =  ItemOrder::join('item_models','item_orders.id_item','item_models.id')
        ->join('orders','item_orders.no_invoice','orders.no_invoice')
        ->where('item_orders.cabang_id',$cabang)->where('item_orders.status','=',"Sedang diproduksi")
        ->where('orders.tanggal_kirim',$now)
        ->select(
                'item_orders.cabang_id',
                'item_models.nama_item',
                'item_orders.status',
                DB::raw('SUM(item_orders.qty) as qtys'))
        ->orderby('item_models.nama_item','asc')
        ->GroupBy('item_orders.cabang_id','item_models.nama_item','item_orders.status')
        ->get();
            // dd($item);
        return view('order/dataitem',compact('cabang','item','now'));
    }
    
    public function filterdataitem(Request $request){
        $cabang = Auth::user()->cabang_id;
        $cek = $request->datetimes;
        $string = explode('-',$cek);

        $date1 = explode('/',$string[0]);
        $date2 = explode('/',$string[1]);

        $finalDate1 = $date1[0].'-'.$date1[1].'-'.$date1[2];
        $finalDate2 = $date2[0].'-'.$date2[1].'-'.$date2[2];
        $item =  ItemOrder::join('item_models','item_orders.id_item','item_models.id')
        ->join('orders','item_orders.no_invoice','orders.no_invoice')
        ->where('item_orders.cabang_id',$cabang)->where('item_orders.status','=',"Sedang diproduksi")
        ->where('orders.tanggal_kirim',[$finalDate1, $finalDate2])
        ->select(
                'item_orders.cabang_id',
                'item_models.nama_item',
                'item_orders.status',
                DB::raw('SUM(item_orders.qty) as qtys'))
        ->orderby('item_models.nama_item','asc')
        ->GroupBy('item_orders.cabang_id','item_models.nama_item','item_orders.status')
        ->get();
            // dd($item);
        return view('order/dataitem',compact('cabang','item','cek','finalDate1','finalDate2','string','date1','date2'));
    }
    
    public function edittime(Request $request){
        $invoice = $request->invoice;
        $tanggal = $request->tanggal;
        $jam = $request->jam;
        $order = Order::where('no_invoice',$invoice)->update(['tanggal_kirim' => $tanggal,'jam_kirim' => $jam]);
        $detail = DetailOrder::where('no_invoice',$invoice)->update(['tanggal_kirim' => $tanggal,'jam_kirim' => $jam]);
        
         return back()->with('succes','Good  Job!');
        
    }
    public function selesai(Request $request){
        $invoice = $request->invoice;
        $idpaket = $request->id_paket;
        $qty     = $request->qty;
         $now = date('Y-m-d');
        $order = Order::where('no_invoice',$invoice)->update([
            'status' => "Selesai"
        ]);
        $detail = DetailOrder::where('no_invoice',$invoice)->update([
                'status' => "Selesai"
            ]);
        // dd($detail);
        
        // dd($id);
        $input = ItemOrder::where('no_invoice',$invoice)->update(['status' => "Selesai"]);
        // $item = ItemOrder::join('item_models','item_orders.id_item','item_models.id')
        // ->join('komposisi_models','item_models.id_resep','komposisi_models.id')
        // ->where('item_orders.no_invoice',$invoice)
        // ->select('komposisi_models.id_bahanbaku','komposisi_models.gramasi','komposisi_models.id_resep','komposisi_models.total_harga_up','item_orders.id_item','komposisi_models.id_satuan','item_orders.cabang_id')
        // ->get();
        $item = DB::table('komposisi_models')->join('item_models','komposisi_models.id_resep','item_models.id_resep')
                                            ->join('item_orders','item_models.id','item_orders.id_item')
                                            ->where('item_orders.no_invoice',$invoice)
                                            ->select('komposisi_models.id_bahanbaku','komposisi_models.gramasi','komposisi_models.id_resep','komposisi_models.total_harga_up','item_orders.id_item','komposisi_models.id_satuan','item_orders.cabang_id')
        ->get();
        // dd($item);
        foreach($item as $items){
            $id_item = $items->id_item;
            $id_resep = $items->id_resep;
            $gramasi = $items->gramasi;
            $harga = $items->total_harga_up;
            $bahanbaku = $items->id_bahanbaku;
            $cabang  = $items->cabang_id;
            $satuan = $items->id_satuan;
            
        $cek = DB::table('pengeluaran_bahans')->where('id_item',$id_item)->where('no_invoice',$invoice)->where('cabang_id',$cabang)->count();
        $ceks = DB::table('pengeluaran_bahans')->where('id_bahanbaku',$id_item)->where('no_invoice',$invoice)->where('cabang_id',$cabang)->count();
        // dd($cek);
        if($cek){
          
        }
        elseif($ceks){
            $update = DB::table('pengeluaran_bahans')->update(['gramasi'=>('gramasi' + ($gramasi * $qty)),'total_harga'=>('total_harga'+ ($harga * $qty))]);

        }  
        else{
           $masukan = DB::table('pengeluaran_bahans')->insert(['no_invoice'=>$invoice,
                                                                'id_item'=>$id_item,
                                                                'id_bahanbaku'=>$bahanbaku,
                                                                'gramasi'=>($gramasi * $qty),
                                                                'total_harga'=>($harga * $qty),
                                                                'id_satuan'=>$satuan,
                                                                'tanggal_produksi'=>$now,
                                                                'cabang_id'=>$cabang]);
        }
            
        }
        
        
    
        return back()->with('succes','Good  Job!');
  
    }
    public function bayar(Request $request){
        $invo  = $request->invoice;
        $nominal = $request->nominal;
        $input = new PelunasanOrder();
        $input->no_invoice = $invo;
        $input->nominal = $nominal;
        $input->tanggal_masuk = date('Y-m-d');
        $input->cabang_id = Auth::user()->cabang_id;
        $input->user_id = Auth::user()->id;
        $input->save();
        $update = Order::where('no_invoice',$invo)->update(['bayar'=>DB::raw("bayar + $nominal"),'sisa'=>DB::raw('bigtotal - bayar')]);

        return back()->with('succes','Sukses dibayar');
    }
    public function print(Request $request){
        $id_cabang = Auth::user()->cabang_id;
        $namacabang = CabangModel::where('id',$id_cabang)->select('nama_cabang','no_hp')->get();
        // dd($namacabang);
        $invo  = $request->invoice;
        $nota = Order::where('no_invoice',$invo)
        ->join('users','orders.user_id','users.id')
        ->join('cabang','orders.cabang_id','cabang.id')
        ->join('regencies','orders.id_kota','regencies.id')
        ->join('districts','orders.id_kec','districts.id')
        ->join('villages','orders.id_keluaran','villages.id')
        ->select('orders.no_invoice',
        'orders.nama_cust',
        'orders.jenis_cust',
        'cabang.nama_cabang',
        'users.name',
        'orders.tanggal_kirim',
        'orders.jam_kirim',
        'orders.no_telp',
        'orders.jenis_order',
        'regencies.name as kota',
        'districts.name as kec',
        'villages.name as kel',
        'orders.jalan',
        'orders.patokan',
        'orders.bigtotal',
        'orders.keterangan',
        'orders.bayar',
        'orders.sisa',
        'orders.status')
        ->get();
  
        // $detail = DetailOrder::where('detail_orders.no_invoice',$invo)
        // ->join('paket_models','detail_orders.id_paket','paket_models.id')
        // ->join('orders','detail_orders.no_invoice','orders.no_invoice')
        // ->join('item_orders','detail_orders.no_invoice','item_orders.no_invoice')
        // ->join('item_models','item_orders.id_item','item_models.id')
        // // ->where('item_orders.id_paket',$pak)
        // // ->where('detail_orders.status','=','Selesai')
        // ->select(
        //         // 'detail_orders.id',
        //         'detail_orders.no_invoice',
        //         // 'orders.nama_cust',
        //         'paket_models.nama_paket',
        //         'detail_orders.qty',
        //         // 'orders.tanggal_kirim',
        //         // 'orders.jam_kirim',
        //         'detail_orders.harga',
        //         'detail_orders.subtotal',
        //      DB::raw('GROUP_CONCAT(item_models.nama_item) as items'))
        //                                 ->groupBy('detail_orders.no_invoice','paket_models.nama_paket','detail_orders.qty','detail_orders.harga','detail_orders.subtotal')
        //     ->orderby('orders.tanggal_kirim','asc')
        //     ->orderby('orders.jam_kirim')


        // ->get();
        $detail = DetailOrder::select('detail_orders.no_invoice',
                                        'paket_models.nama_paket',
                                        DB::raw('GROUP_CONCAT(item_models.nama_item) as items'),
                                        'detail_orders.harga',
                                        'detail_orders.qty',
                                        'detail_orders.disc',
                                        'detail_orders.cutsale',
                                        'detail_orders.subtotal')
                                    ->join('paket_models','detail_orders.id_paket','paket_models.id')
                                    ->leftjoin('item_orders','detail_orders.id_paket','=','item_orders.id_paket','AND','detail_orders.no_invoice','=','item_orders.no_invoice')
                                    ->join('item_models','item_orders.id_item','item_models.id')
                                    ->where('detail_orders.no_invoice',$invo)
                                    ->groupBy('paket_models.nama_paket','detail_orders.harga','detail_orders.qty','detail_orders.subtotal','detail_orders.disc',
                                        'detail_orders.cutsale','detail_orders.no_invoice')
                                    ->get();
        
        //  $itemorder = ItemOrder::join('paket_models','item_orders.id_paket','paket_models.id')
        //                         ->join('item_models','item_orders.id_item','item_models.id')
        //                         ->join('detail_orders','item_orders.no_invoice','detail_orders.no_invoice')
        //                         ->where('item_orders.no_invoice',$invo)
        //                         ->select('item_orders.no_invoice',
        //                                 'paket_models.nama_paket',
        //                                 'item_orders.qty',
        //                                 'detail_orders.harga',
        //                                 'detail_orders.subtotal',
        //                                 DB::raw('GROUP_CONCAT(item_models.nama_item) as items'))
        //                                 ->groupBy('paket_models.nama_paket','item_orders.no_invoice','item_orders.qty',
        //                                 'detail_orders.subtotal')
        //                                 ->get();
        //                                  dd($itemorder);
        // ->where('detail_orders.cabang_id',$id_cabang)
        // ->join('orders','detail_orders.no_invoice','orders.no_invoice')
        // ->join('paket_models','detail_orders.id_paket','paket_models.id')
        // ->join('komponen_models','paket_models.code_komponen','komponen_models.code_komponen')
        // ->join('item_models','komponen_models.id_item','item_models.id')
        // // ->where('detail_orders.status','=','Selesai')
        // ->select(
        //         // 'detail_orders.id',
        //         // 'item_models.nama_item',
        //         'detail_orders.no_invoice',
        //         'orders.nama_cust',
        //         'paket_models.nama_paket',
        //         'paket_models.jenis_paket',
        //         'detail_orders.qty',
        //         'orders.tanggal_kirim',
        //         'orders.jam_kirim',
        //         // 'orders.status'
        //         'detail_orders.harga',
        //         'detail_orders.subtotal',
        //         DB::raw('GROUP_CONCAT(item_models.nama_item) as items'))
        //     ->groupby('detail_orders.no_invoice','paket_models.nama_paket','orders.tanggal_kirim',
        //     'orders.jam_kirim','orders.nama_cust','detail_orders.qty','detail_orders.harga','detail_orders.subtotal','paket_models.jenis_paket')
        //     ->orderby('orders.tanggal_kirim','asc')
        //     ->orderby('orders.jam_kirim')


        // ->get();
        // dd($detail);

        return view('order/print',compact('invo','nota','detail','namacabang'));
    }
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
