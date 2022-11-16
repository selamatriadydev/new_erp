<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseModel;
use App\PurchasingModel;
use App\SatuanModel;
use App\BahanbakuModel;
use App\BarangreturnhModel;
use App\BayarsupplierModel;
use App\PembayaranpurchModel;
use App\PengeluaranGudangModel;
use App\CabangModel;
use App\GudangCabangModel;
use App\GudangModel;
use App\Purchase;
use App\BarangGudang;
use App\BarangGudangCabang;
use App\DetailPurchase;
use App\User;
use App\InvoiceBarangMasukModel;
use App\InvPurchProdModel;
use App\KeuntunganGudCabModel;
use App\KeuntunganModel;
use App\PayProdModel;
use App\PurchProdModel;
use App\SatuanBarangModel;
use DateTime;
use DB;
use Illuminate\Support\Facades\Auth;
class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cabs = CabangModel::all();
        $login = Auth::user()->cabang_id;   
        $data = Purchase::join('cabang','purchases.cabang_penerima','=','cabang.id')
        ->join('users','purchases.id_user','users.id')
        ->where('cabang_peminta',$login)
        ->select('purchases.id',
        'purchases.no_purchase',
        'cabang.nama_cabang',
        'users.name',
        'purchases.tanggal_purchase',
        'purchases.nama_gudang',
        'purchases.sisa',
        'purchases.due_date',
        'purchases.big_total',
        'purchases.bayar',
        'purchases.sisa',
        'purchases.status')
        ->orderBy('purchases.id','desc')
        ->get();
        $sum = Purchase::where('cabang_peminta',$login)->sum('sisa');
        // dd($cabs);
        return view('purchase.index',compact('data','sum','login','cabs'));
    }
    public function purchasein()
    {
        $login = Auth::user()->hak_akses;   
        $data = Purchase::join('cabang','purchases.cabang_penerima','=','cabang.id')
        ->join('users','purchases.id_user','users.id')
        ->where('nama_gudang',$login)
        ->select('purchases.id',
        'purchases.no_purchase',
        'cabang.nama_cabang',
        'users.name',
        'purchases.tanggal_purchase',
        'purchases.nama_gudang',
        'purchases.sisa',
        'purchases.due_date',
        'purchases.big_total',
        'purchases.bayar',
        'purchases.sisa',
        'purchases.status')
        ->orderBy('purchases.id','desc')
        ->get();
        $sum = PurchasingModel::where('nama_gudang',$login)->sum('sisa');
        // dd($login);
        return view('purchase.purchin',compact('data','login','sum'));
    }

    public function penjualan(){

        return view('penjualangudang.penjualan');
    }

    public function payment()
    {
          
        $data = Purchase::join('cabang','purchases.cabang_peminta','=','cabang.id')
        ->select('purchases.id',
        'purchases.no_purchase',
        'purchases.big_total',
        'purchases.bayar',
        'purchases.sisa',
        'purchases.due_date',
        'cabang.nama_cabang',
        'purchases.sisa',
        'purchases.status')
        ->orderBy('purchases.id','desc')
        ->get();
        $sum = Purchase::sum('sisa');
        $sum2 = Purchase::sum('big_total');
        $sum3 = Purchase::sum('bayar');
        return view('payment.payment',compact('data','sum','sum2','sum3'));
    }

    public function lihat($id)
    {
        $purc = Purchase::find($id);
        $no = $purc->no_purchase;
        
        $tampil2 = $purc->big_total;
        // $tampil = PurchaseModel::where('no_purchase','er')->get();
        $qtyawal = $purc->quantity;
        
        $tampil = DetailPurchase::join('barang_gudangs','detail_purchases.code_barang_model','barang_gudangs.code_barang_model')
        ->join('satuan_models','detail_purchases.id_satuan','satuan_models.id')
        ->where('detail_purchases.no_purchase',$no)
        ->select('detail_purchases.id',
        'detail_purchases.no_purchase',
        'barang_gudangs.nama_barang',
        'detail_purchases.berat',
        'satuan_models.nama_satuan',
        'detail_purchases.harga_jual',
        'detail_purchases.quantity',
        'detail_purchases.sub_total_jual',
        'detail_purchases.status'
        )
        ->orderBy('detail_purchases.id','desc')
        ->get();
        // dd($pu);
        return view('purchase.detail',compact('purc','tampil','tampil2','no','qtyawal'));
    }

    public function tostok($id){
        $tampil = DetailPurchase::find($id);
        $tampil->update(['status' => "in stok"]);
        $bahanbaku =  $tampil->code_barang_model;
        $berat = $tampil->berat;
        $satuan = $tampil->id_satuan;
        $harga_pokok = $tampil->harga_pokok;
        $harga_jual = $tampil->harga_jual;
        $sub_total_pokok = $tampil->sub_total_pokok;
        $sub_total_jual =  $tampil->sub_total_jual;
        $stok = $tampil->quantity;
        $cabang = Auth::user()->cabang_id;
        $hak = Auth::user()->hak_akses;
        $cek = BarangGudangCabang::where('code_barang_model',$bahanbaku)->count();
        $tes = BarangGudangCabang::where('code_barang_model',$bahanbaku)
        ->where('harga_pokok','<',$harga_pokok)->count();
        
            if($tes){
                $up = BarangGudangCabang::where('code_barang_model',$bahanbaku)
                ->where('harga_pokok','<',$harga_pokok)->update([
                    'stok'=> DB::raw("stok + $stok"),
                    'harga_pokok'=>DB::raw($harga_pokok),
                    'harga_jual'=>DB::raw('margin' + $harga_pokok)
                ]);
    
            }
           elseif($cek){
                $up = BarangGudangCabang::where('code_barang_model',$bahanbaku)
                ->update([
                    'stok'=> DB::raw("stok + $stok"),
                    'sub_total_pokok' =>DB::raw('harga_pokok * stok'),
                    'sub_total_jual' =>DB::raw('harga_jual * stok')

                ]);
    
                }
            else{
                $nama_barang = BarangGudang::where('code_barang_model',$bahanbaku)->get();
                foreach($nama_barang as $nambar){
                    $nb = $nambar->nama_barang;
                    $m = $nambar->margin;
                }
                $hust = BarangGudangCabang::insert(['code_barang_model'=>$bahanbaku,
                
                'nama_barang' => $nb,
                'berat' => $berat,
                'harga_pokok'=> $harga_pokok,
                'harga_jual'=> $harga_jual,
                'margin' => $m,
                'stok'=>$stok,
                'berat' => $berat,
                'id_satuan' => $satuan,
                'sub_total_pokok' => $sub_total_pokok,
                'sub_total_jual' => $sub_total_jual,
                'cabang_id'=>$cabang,
                'nama_gudang'=>$hak]);
            }
        
        // dd($tes);
        return redirect()->back();
    }

    public function laporanpayment(){
        
        $gudangbesar = "Admin Bigwarehouse";

        $omset = Purchase::sum('big_total');
        $omsetgudang = KeuntunganModel::sum('sub_total');
        $omsetgudang1 = KeuntunganModel::sum('sub_totalpk');
        $omsetgudang2 = PengeluaranGudangModel::sum('total');
        $pengeluaran  = PengeluaranGudangModel::join('jenis_pengeluaran_models','pengeluaran_gudang_models.id_guna','jenis_pengeluaran_models.id')
                        ->groupBy('jenis_pengeluaran_models.nama_pengeluaran')
                        ->selectRaw('sum(total) as sum,jenis_pengeluaran_models.nama_pengeluaran')
                        ->get();
        $uangmasuk = PembayaranpurchModel::sum('nominal');
        $sisa = Purchase::sum('sisa');
        $hutang  = InvoiceBarangMasukModel::sum('sisa');
        $gudang = GudangModel::sum('sub_totalpk');
        $bayarsup  = BayarsupplierModel::sum('nominal');

        $omsetgudangbesar = Purchase::where('nama_gudang','=',"Admin Bigwarehouse")->sum('big_total');
        $omsetgudangtelur = Purchase::where('nama_gudang','=',"Admin Eggwarehouse")->sum('big_total');
        $omsetgudangpremix = Purchase::where('nama_gudang','=',"Admin Premixwarehouse")->sum('big_total');

        $uangmasukgudangbesar = PembayaranpurchModel::join('purchasing_models','pembayaranpurch_models.no_purchase','purchasing_models.no_purchase')
        ->where('purchasing_models.nama_gudang','=','Admin Bigwarehouse')->sum('pembayaranpurch_models.nominal');
        $sisagudangbesar = Purchase::where('nama_gudang','=','Admin Bigwarehouse')->sum('sisa');
        
        
        $keuntungangudangbesar = KeuntunganModel::where('nama_gudang',$gudangbesar)->sum('sub_total');
        $keuntungangudangpremix = DetailPurchase::where('nama_gudang','=',"Admin Premixwarehouse")->sum('harga_jual');
        $keuntungangudangtelur = DetailPurchase::where('nama_gudang','=',"Admin Eggwarehouse")->sum('harga_jual');
        
        $uanggudangbesar = DetailPurchase::join('bahanbaku','detail_purchases.id_barang','bahanbaku.id')->where('detail_purchases.nama_gudang','=',"Admin Bigwarehouse")->sum('bahanbaku.harga_up');
        $uanggudangpremix = DetailPurchase::join('bahanbaku','detail_purchases.id_barang','bahanbaku.id')->where('detail_purchases.nama_gudang','=',"Admin Premixwarehouse")->sum('bahanbaku.harga_up');
        $uanggudangtelur = DetailPurchase::join('bahanbaku','detail_purchases.id_barang','bahanbaku.id')->where('detail_purchases.nama_gudang','=',"Admin Eggwarehouse")->sum('bahanbaku.harga_up');
        
        $subtot = KeuntunganModel::where('nama_gudang',$gudangbesar)->sum('sub_total');
        $subtotpk = KeuntunganModel::where('nama_gudang',$gudangbesar)->sum('sub_totalpk');
        // dd($pengeluaran);
        return view('payment.laporan',compact('bayarsup','omsetgudang','hutang','omsetgudang1','omsetgudang2','uangmasuk'
        ,'sisa','omsetgudangbesar','uangmasukgudangbesar','sisagudangbesar',
        'omsetgudangtelur',
        'omsetgudangpremix',
        'omset',
        'keuntungangudangbesar','keuntungangudangpremix','keuntungangudangtelur',
        'uanggudangbesar','uanggudangpremix','uanggudangtelur','gudangbesar','subtot','subtotpk','gudang','pengeluaran'));
    }
    public function lihatin($id)
    {
        $purc = Purchase::find($id);
        $no = $purc->no_purchase;
        // $idbarang = $purc->id_bahanbaku;
        $tampil2 = $purc->big_total;
        // $tampil = PurchaseModel::where('no_purchase','er')->get();
        $qtyawal = $purc->quantity;
        
        $tampil = DetailPurchase::join('barang_gudangs','detail_purchases.code_barang_model','barang_gudangs.code_barang_model')
        ->join('satuan_models','barang_gudangs.id_satuan','satuan_models.id')
        ->where('no_purchase',$no)
        ->select('detail_purchases.id',
        'detail_purchases.no_purchase',
        'barang_gudangs.nama_barang',
        'barang_gudangs.berat',
        'barang_gudangs.harga_jual',
        'satuan_models.nama_satuan',
        'detail_purchases.quantity',
        'detail_purchases.status',
        'detail_purchases.sub_total_jual'

        )
        ->orderBy('barang_gudangs.id','desc')
        ->get();
        // $cekstok = SatuanBarangModel::where('id',$idbarang)->select('stok')->get();
        // dd($tampil);        
        return view('purchase.detailin',compact('purc','tampil','tampil2','no','qtyawal'));
    }
    public function detailbarang($id)
    {
        $purc = PurchasingModel::find($id);
        $no = $purc->no_purchase;
        
        $tampil2 = $purc->big_total;
        // $tampil = PurchaseModel::where('no_purchase','er')->get();
        $qtyawal = $purc->quantity;
        
        $tampil = PurchaseModel::join('gudang_models','purchase_models.id_bahanbaku','gudang_models.id')
        ->join('satuan_models','purchase_models.id_satuan','satuan_models.id')
        ->where('purchase_models.no_purchase',$no)
        ->select('purchase_models.id',
        'purchase_models.no_purchase',
        'gudang_models.nama_barang',
        'purchase_models.berat',
        'satuan_models.nama_satuan',
        'purchase_models.harga',
        'purchase_models.quantity',
        'purchase_models.sub_total',
        'purchase_models.status'
        )
        ->orderBy('purchase_models.id','desc')
        ->get();
        // dd($pu);
        return view('payment.detailbarang',compact('purc','tampil','tampil2','no','qtyawal'));
    }


    public function tampilreturn(){

        $login = Auth::user()->hak_akses;
        $return = BarangreturnhModel::join('gudang_models','barangreturnh_models.id_barang','gudang_models.id')
        ->where('nama_gudang',$login)
        ->select('barangreturnh_models.id',
            'barangreturnh_models.nama_gudang',
            'gudang_models.nama_barang',
            'barangreturnh_models.qty',
            'barangreturnh_models.status',
            'barangreturnh_models.no_purchase',
            'barangreturnh_models.nama_gudang',
            'gudang_models.harga_pk')
        ->get();
        // dd($return);    
        return view('purchase/return',compact('return','login'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $satuan = SatuanModel::all();
        $users =  CabangModel::all();
        $date = new DateTime();
        $ldate = date('Y-m-d');
        $cabang1 = "PURC";
        $bahanbaku = BarangGudang::join('satuan_models','barang_gudangs.id_satuan','satuan_models.id')
        ->where('barang_gudangs.stok','>',"2")
        ->select('barang_gudangs.code_barang_model',
        'barang_gudangs.id',
        'barang_gudangs.nama_barang',
        'satuan_models.nama_satuan',
        'barang_gudangs.stok')
        ->get();
        $pilcab = CabangModel::where('fungsi','=','warehouse')->get();
        $cabang = CabangModel::all();
        $req = Purchase::select('no_purchase')->orderby('created_at','desc')->first();

        if($req != null){
            $bulan = $date->format('m');
            $bulanreq = substr($req->no_req,6,2);
            if($bulan == $bulanreq){
                $pcod = substr($req->no_req,13);
                $codplus = (int)$pcod + 1;
                $codigit = sprintf("%03s",$codplus);
                $kode = $cabang1.'-'.$date->format('d/His');
            }else{
                $kode = $cabang1.'-'.$date->format('d/His');
            }
        }else{
            $kode = $cabang1.'-'.$date->format('d/His');
        }

    //    dd($bahanbaku);
        return view('purchase/create',compact('users','cabang1','cabang','kode','date','req','satuan','ldate','bahanbaku','pilcab'));
    }

    public function createbig()
    {
        $users = CabangModel::all();
        $satuan = SatuanModel::all();
        $hak_akses = Auth::user()->hak_akses;
        $date = new DateTime();
        $ldate = date('Y-m-d');
        $cabang1 = "PURC";
        $tiga = "2";
        $bahanbaku = BarangGudang::join('satuan_models','barang_gudangs.id_satuan','satuan_models.id')
        ->where('barang_gudangs.nama_gudang',$hak_akses)
        ->where('barang_gudangs.stok','>',"2")
        ->select('barang_gudangs.code_barang_model',
        'barang_gudangs.id',
        'barang_gudangs.nama_barang',
        'barang_gudangs.berat',
        'satuan_models.nama_satuan',
        'barang_gudangs.stok')
        ->get();
        $pilcab = CabangModel::where('fungsi','=','warehouse')->get();
        $cabang = CabangModel::all();
        $req = Purchase::select('no_purchase')->orderby('created_at','desc')->first();

        if($req != null){
            $bulan = $date->format('m');
            $bulanreq = substr($req->no_req,6,2);
            if($bulan == $bulanreq){
                $pcod = substr($req->no_req,13);
                $codplus = (int)$pcod + 1;
                $codigit = sprintf("%03s",$codplus);
                $kode = $cabang1.'-'.$date->format('d/His');
            }else{
                $kode = $cabang1.'-'.$date->format('d/His');
            }
        }else{
            $kode = $cabang1.'-'.$date->format('d/His');
        }


        // dd($bahanbaku);
        return view('purchase/createbig',compact('tiga','users','cabang1','cabang','kode','date','req','satuan','ldate','bahanbaku','pilcab'));
    }
    public function formprod()
    {
        $satuan = SatuanModel::all();
        $date = new DateTime();
        $ldate = date('Y-m-d');
        $cabang1 = "PProd";
        $us = Auth::user()->cabang_id;
        $bahanbaku = GudangCabangModel::where('cabang_id',$us)->get();
        $pilcab = CabangModel::where('fungsi','=','warehouse')->get();
        $cabang = CabangModel::all();
        $req = PurchasingModel::select('no_purchase')->orderby('created_at','desc')->first();

        if($req != null){
            $bulan = $date->format('m');
            $bulanreq = substr($req->no_req,6,2);
            if($bulan == $bulanreq){
                $pcod = substr($req->no_req,13);
                $codplus = (int)$pcod + 1;
                $codigit = sprintf("%03s",$codplus);
                $kode = $cabang1.'-'.$date->format('d/His');
            }else{
                $kode = $cabang1.'-'.$date->format('d/His');
            }
        }else{
            $kode = $cabang1.'-'.$date->format('d/His');
        }

    //    dd($pilcab);
        return view('purprod/create',compact('cabang1','cabang','kode','date','req','satuan','ldate','bahanbaku','pilcab'));
    }
    public function premix()
    {
        $users = CabangModel::all();
        $satuan = SatuanModel::all();
        $date = new DateTime();
        $ldate = date('Y-m-d');
        $cabang1 = "PURC";
        $bahanbaku = BarangGudang::join('satuan_models','barang_gudangs.id_satuan','satuan_models.id')
        ->where('barang_gudangs.stok','>',"2")
        ->where('barang_gudangs.nama_gudang','=',"Admin Premixwarehouse")
        ->select('barang_gudangs.code_barang_model',
        'barang_gudangs.id',
        'barang_gudangs.nama_barang',
        'barang_gudangs.berat',
        'satuan_models.nama_satuan',
        'barang_gudangs.stok')
        ->get();
        $pilcab = CabangModel::where('fungsi','=','warehouse')->get();
        $cabang = CabangModel::all();
        $req = Purchase::select('no_purchase')->orderby('created_at','desc')->first();

        if($req != null){
            $bulan = $date->format('m');
            $bulanreq = substr($req->no_req,6,2);
            if($bulan == $bulanreq){
                $pcod = substr($req->no_req,13);
                $codplus = (int)$pcod + 1;
                $codigit = sprintf("%03s",$codplus);
                $kode = $cabang1.'-'.$date->format('d/His');
            }else{
                $kode = $cabang1.'-'.$date->format('d/His');
            }
        }else{
            $kode = $cabang1.'-'.$date->format('d/His');
        }


    //    dd($bahanbaku);
        return view('purchase/premix',compact('users','cabang1','cabang','kode','date','req','satuan','ldate','bahanbaku','pilcab'));
    }
    public function egg()
    {
        $users = CabangModel::all();
        $satuan = SatuanModel::all();
        $date = new DateTime();
        $ldate = date('Y-m-d');
        $idcabang = Auth::user()->cabang_id;
        $hak_akses = Auth::user()->hak_akses;
        $cabang1 = "PURC";
        $bahanbaku = BarangGudang::join('satuan_models','barang_gudangs.id_satuan','satuan_models.id')
        ->where('barang_gudangs.stok','>',"2") 
        ->where('barang_gudangs.nama_gudang','=',"Admin Eggwarehouse")
        ->select('barang_gudangs.code_barang_model',
        'barang_gudangs.id',
        'barang_gudangs.nama_barang',
        'barang_gudangs.berat',
        'satuan_models.nama_satuan',
        'barang_gudangs.stok')
        ->get();
        $pilcab = CabangModel::where('fungsi','=','warehouse')->get();
        $cabang = CabangModel::all();
        $req = Purchase::select('no_purchase')->orderby('created_at','desc')->first();

        if($req != null){
            $bulan = $date->format('m');
            $bulanreq = substr($req->no_req,6,2);
            if($bulan == $bulanreq){
                $pcod = substr($req->no_req,13);
                $codplus = (int)$pcod + 1;
                $codigit = sprintf("%03s",$codplus);
                $kode = $cabang1.'-'.$date->format('d/His');
            }else{
                $kode = $cabang1.'-'.$date->format('d/His');
            }
        }else{
            $kode = $cabang1.'-'.$date->format('d/His');
        }


    //    dd($pilcab);
        return view('purchase/egg',compact('users','cabang1','cabang','kode','date','req','satuan','ldate','bahanbaku','pilcab','idcabang'));
    }
    public function big()
    {
        $satuan = SatuanModel::all();
        $users =  CabangModel::all();
        $date = new DateTime();
        $ldate = date('Y-m-d');
        $cabang1 = "PURC";
        $bahanbaku = BarangGudang::join('satuan_models','barang_gudangs.id_satuan','satuan_models.id')
        ->where('barang_gudangs.stok','>',"2")
        ->where('barang_gudangs.nama_gudang','=',"Admin Bigwarehouse")
        ->select('barang_gudangs.code_barang_model',
        'barang_gudangs.id',
        'barang_gudangs.berat',
        'barang_gudangs.nama_barang',
        'satuan_models.nama_satuan',
        'barang_gudangs.stok')
        ->get();
        $pilcab = CabangModel::where('fungsi','=','warehouse')->get();
        $cabang = CabangModel::all();
        $req = Purchase::select('no_purchase')->orderby('created_at','desc')->first();

        if($req != null){
            $bulan = $date->format('m');
            $bulanreq = substr($req->no_req,6,2);
            if($bulan == $bulanreq){
                $pcod = substr($req->no_req,13);
                $codplus = (int)$pcod + 1;
                $codigit = sprintf("%03s",$codplus);
                $kode = $cabang1.'-'.$date->format('d/His');
            }else{
                $kode = $cabang1.'-'.$date->format('d/His');
            }
        }else{
            $kode = $cabang1.'-'.$date->format('d/His');
        }


    //    dd($users);
        return view('purchase/big',compact('satuan','users','date','ldate','cabang1','bahanbaku','pilcab','cabang','req','kode'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $no_purchase  = $request->no_purchase;
        $purchaser = $request->purchasers;
        $tgl_purchase = $request->tanggal_purchase;
        $cabang_pembuat = $request->pembuat;
        $nama_gudang = $request->id_gudang;
        $id_gudang    = $request->id_gudang;
        $ldate        = date('Y-m-d');
        $minggu2      = date('Y-m-d', strtotime('+2 week', strtotime($ldate)));
        $big_total    = $request->big_total;
        $biayarepack  = $request->biayarepack;
        $status       = "Hutang";
        // dd($nama_gudang);

        foreach($request->id_bahanbaku as $key => $value)
        {
            $input = new DetailPurchase(); 
            $input->no_purchase = $no_purchase; 
            $input->nama_gudang = $id_gudang; 
            $input->code_barang_model = $value;
            $bahanbaku = BarangGudang::where('code_barang_model',$value)->get();
            // dd($value);
            foreach($bahanbaku as $bah){
                $id = $bah->id;
                $harga_pokok = $bah->harga_pokok;
                $harga_jual = $bah->harga_jual;
                $berat = $bah->berat;
                $id_satuan = $bah->id_satuan;

            }

            $input->berat = $berat;
            $input->id_satuan = $id_satuan;
            $input->harga_pokok = $harga_jual;
            if(Auth::user()->hak_akses == "Admin Premixwarehouse"){
                $input->harga_pokok = $harga_pokok;
                $input->harga_jual = $harga_pokok;
            }
            else{
                $input->harga_pokok = $harga_pokok;
                $input->harga_jual = $harga_jual;
            }
            $input->quantity = $request->quantity[$key];
            if(Auth::user()->hak_akses == "Admin Premixwarehouse"){
                $rego = $harga_pokok;
                $akehe = $request->quantity[$key];
                $sub = ($rego * $akehe);
                $input->sub_total_pokok = $sub;
                $input->sub_total_jual = $sub;

            }
            else{
                $rego = $harga_pokok;
                $rego2 = $harga_jual;
                $akehe = $request->quantity[$key];
                $sub = ($rego * $akehe);
                $sub2 = ($rego2 * $akehe);
                $input->sub_total_pokok = $sub;
                $input->sub_total_jual = $sub2;
            }
            
            $input->status = "Open";
            $input->save();
        }
   
        // dd($sub);
        $cek_user = Auth::user()->cabang_id;


        // if($cek_user = $cabang_pembuat){
        // Purchase::create([
        //         'no_purchase' => $no_purchase,
        //         'cabang_peminta' => $cabang_pembuat,
        //         'cabang_penerima' => Auth::user()->cabang_id,
        //         'id_user' => Auth::user()->id,
        //         // 'purchasers' => $purchaser,
        //         'tanggal_purchase' => $ldate,
        //         'nama_gudang' => $nama_gudang,
        //         'due_date' => $minggu2,
        //         'status' => "Purchase"

        //     ]);
        // }
        // else{
            Purchase::create([
                'no_purchase' => $no_purchase,
                'cabang_peminta' => Auth::user()->cabang_id,
                'cabang_penerima' => $cabang_pembuat,
                'id_user' => Auth::user()->id,
                // 'purchasers' => $purchaser,
                'tanggal_purchase' => $ldate,
                'nama_gudang' => $nama_gudang,
                'due_date' => $minggu2,
                'status' => "Purchase"

            ]);
        // }
       
       
        
        // dd($nama_gudang);
        return back()->with('success', 'Record Created Successfully.');
    }

    public function storebig(Request $request)
    {
        $no_purchase  = $request->no_purchase;
        $purchaser    = $request->purchasers;
        $tgl_purchase = $request->tanggal_purchase;
        $cabang_peminta= $request->pembuat;
        $cabang_penerima= Auth::user()->cabang_id;
        $nama_gudang    = Auth::user()->hak_akses;
        $ldate        = date('Y-m-d');
        $minggu2      = date('Y-m-d', strtotime('+2 week', strtotime($ldate)));
        $big_total    = $request->big_total;
        $status       = "Hutang";
        

        foreach($request->id_bahanbaku as $key => $value)
        {
            $input = new DetailPurchase(); 
            $input->no_purchase = $no_purchase; 
            $input->nama_gudang = $nama_gudang; 
            $input->code_barang_model = $value;
            $bahanbaku = BarangGudang::where('code_barang_model',$value)->get();
            // dd($bahanbaku);
            foreach($bahanbaku as $bah){
                $id = $bah->id;
                $harga_jual = $bah->harga_jual;
                $harga_pokok = $bah->harga_pokok;
                $berat = $bah->berat;
                $id_satuan = $bah->id_satuan;

            }

            $input->berat = $berat;
            $input->id_satuan = $id_satuan;
            $input->harga_pokok = $harga_pokok;
            if(Auth::user()->hak_akses == "Admin Premixwarehouse"){
                $input->harga_jual = $harga_pokok;
            }
            else{
                $input->harga_jual = $harga_jual;
            }
            $input->quantity = $request->quantity[$key];
            if(Auth::user()->hak_akses == "Admin Premixwarehouse"){
                $rego = $harga_pokok;
            }
            else{
                $rego = $harga_jual;
            }
            $akehe = $request->quantity[$key];
            $sub = ($rego * $akehe);
            $sub_pokok = $harga_pokok * $akehe;
            $input->sub_total_pokok = $sub_pokok;
            $input->sub_total_jual = $sub;
            $input->status = "Open";
            $input->save();
        }
        $cek_user = Auth::user()->cabang_id;


        // if($cek_user = $cabang_pembuat){
        // Purchase::create([
        //         'no_purchase' => $no_purchase,
        //         'cabang_peminta' => Auth::user()->cabang_id,
        //         'cabang_penerima' => $cabang_pembuat,
        //         'id_user' => Auth::user()->id,
        //         // 'purchasers' => $purchaser,
        //         'tanggal_purchase' => $ldate,
        //         'nama_gudang' => $nama_gudang,
        //         'due_date' => $minggu2,
        //         'status' => "Purchase"

        //     ]);
        // }
        // else{
            Purchase::create([
                'no_purchase' => $no_purchase,
                'cabang_peminta' => $cabang_peminta,
                'cabang_penerima' => Auth::user()->cabang_id,
                'id_user' => Auth::user()->id,
                // 'purchasers' => $purchaser,
                'tanggal_purchase' => $ldate,
                'nama_gudang' => $nama_gudang,
                'due_date' => $minggu2,
                'status' => "Purchase"

            ]);
        // }
        // dd($cek_user);
        return back()->with('success', 'Record Created Successfully.');
    }
    public function storeprod(Request $request)
    {
        $no_purchase  = $request->no_purchase;
        $tgl_purchase = $request->tanggal_purchase;
        $id_user      = Auth::user()->id;
        $id_gudang    = $request->nama_gudang;
        $ldate        = date('Y-m-d');
        $minggu2      = date('Y-m-d', strtotime('+2 week', strtotime($ldate)));
        $big_total    = $request->big_total;
        $status       = "Tempo";
        

        foreach($request->id_bahanbaku as $key => $value)
        {
            $input = new PurchProdModel(); 
            $input->no_purchase = $no_purchase; 
            $input->nama_gudang = $id_gudang; 
            $input->id_bahanbaku = $value;
            $aut = Auth::user()->cabang_id;
            $bahanbaku = GudangCabangModel::where('cabang_id',$aut)->where('id',$value)->get();
            foreach($bahanbaku as $bah){
                $id = $bah->id;
                $hargapk = $bah->harga_pk;
                $hargaup = $bah->harga_up;
                $berat = $bah->berat;
                $id_satuan = $bah->id_satuan;

            }

            $input->berat = $berat;
            $input->id_satuan = $id_satuan;
            $input->harga_pk = $hargapk;
            $input->harga = $hargaup;
            $input->quantity = $request->quantity[$key];
            $qty = $request->quantity[$key];
            $rego = $hargaup;
            $akehe = $request->quantity[$key];
            $sub = ($rego * $akehe);
            $input->sub_total = $sub;
            $big_total += $sub;
            $input->status = "Open";
            $orang = User::where('id',$id_user)->select('cabang_id')->get();
            foreach($orang as $or){
                $id_orang = $or->cabang_id;
            }
            $up = GudangCabangModel::where('cabang_id',$id_orang)->where('id',$value)->update([
                'stok'=> DB::raw("stok - $qty")
            ]);
            $input->save();
        }

       
        

        InvPurchProdModel::create([
                'no_purchase' => $no_purchase,
                'id_user' => $id_user,
                'tanggal_purchase' => $ldate,
                'nama_gudang' => $id_gudang,
                'due_date' => $minggu2,
                'big_total' => $big_total,
                'sisa' => $big_total,
                'status' => "Purchase"

            ]);


            $inputkeun = new KeuntunganGudCabModel();
            $inputkeun->no_purchase = $no_purchase;
            $idp = InvPurchProdModel::where('no_purchase',$no_purchase)->get();
            foreach($idp as $idpp){
                $id_purd = $idpp->id;
            }
            $inputkeun->id_purchase = $id_purd;
            $inputkeun->id_bahanbaku = $value;
            $inputkeun->harga_pk = $hargapk;
            $inputkeun->harga_up = $hargaup;
            $inputkeun->quantity = $qty;
            $sub_pk = $hargapk * $qty;
            $inputkeun->subtotalpk = $sub_pk;
            $inputkeun->subtotalup = $sub;
            $inputkeun->nama_gudang = $id_gudang;
            $inputkeun->cabang_id = $aut;
            $inputkeun->save();     
        // dd($bahanbaku);
        return back()->with('success', 'Record Created Successfully.');
    }

    public function detailpayprod($id){
        $cari = InvPurchProdModel::find($id);
        $inv = $cari->no_purchase;
        $isi = PurchProdModel::join('gudang_cabang_models','purch_prod_models.id_bahanbaku','gudang_cabang_models.id')
        ->join('satuan_models','purch_prod_models.id_satuan','satuan_models.id')
        ->where('no_purchase',$inv)
        ->select('gudang_cabang_models.nama_barang',
        'purch_prod_models.berat',
        'satuan_models.nama_satuan',
        'purch_prod_models.harga_pk',
        'purch_prod_models.harga',
        'purch_prod_models.quantity',
        'purch_prod_models.sub_total',
        'purch_prod_models.status'
        )
        ->get();

        $det = PayProdModel::where('no_purchase',$inv)->get();
        $su = PayProdModel::where('no_purchase',$inv)->sum('nominal');

        return view('purprod.detailpayprod',compact('cari','inv','det','su','isi'));
    }

    public function printprod($id){

        $cari = InvPurchProdModel::find($id);
        $inv = $cari->no_purchase;
        $pu = $cari->no_purchase;
        $tgl = $cari->tanggal_purchase;
        $big = $cari->big_total;
        $bayar = $cari->bayar;
        $bi = $cari->big_total;
        $sisa = $cari->sisa;
        $due = $cari->due_date;
        $tgl = $cari->tanggal_purchase;
        $iduser = $cari->id_user;
        $user = User::join('cabang','users.cabang_id','cabang.id')
        ->where('users.id',$iduser)
        ->select('cabang.nama_cabang')
        ->get();
        foreach($user as $uss){
            $idcab = $uss->nama_cabang;
        }
        $isi = PurchProdModel::join('gudang_cabang_models','purch_prod_models.id_bahanbaku','gudang_cabang_models.id')
        ->join('satuan_models','purch_prod_models.id_satuan','satuan_models.id')
        ->where('no_purchase',$inv)
        ->select('gudang_cabang_models.nama_barang',
        'purch_prod_models.berat',
        'satuan_models.nama_satuan',
        'purch_prod_models.harga_pk',
        'purch_prod_models.harga',
        'purch_prod_models.quantity',
        'purch_prod_models.sub_total',
        'purch_prod_models.status'
        )
        ->get();

        return view('purprod.print',compact('inv','isi','cari','pu','bayar','bi','sisa','due','tgl','iduser','user','idcab'));
    }

    public function indexprod(){

        $login = Auth::user()->id;   
        $data = InvPurchProdModel::join('users','inv_purch_prod_models.id_user','=','users.id')
        ->where('inv_purch_prod_models.id_user',$login)
        ->select('inv_purch_prod_models.id',
        'inv_purch_prod_models.no_purchase',
        'inv_purch_prod_models.big_total',
        'inv_purch_prod_models.bayar',
        'inv_purch_prod_models.sisa',
        'inv_purch_prod_models.due_date',
        'users.name',
        'inv_purch_prod_models.nama_gudang',
        'inv_purch_prod_models.status')
        ->orderBy('inv_purch_prod_models.id','desc')
        ->get();
        $sum = InvPurchProdModel::where('id_user',$login)->sum('sisa');
        // dd($data);
        return view('purprod.index',compact('data','sum','login'));
    }
    
    public function detailprod($id)
    {
        $purc = InvPurchProdModel::find($id);
        $no = $purc->no_purchase;
        
        $tampil2 = $purc->big_total;
        // $tampil = PurchaseModel::where('no_purchase','er')->get();
        $qtyawal = $purc->quantity;
        
        $tampil = PurchProdModel::join('gudang_cabang_models','purch_prod_models.id_bahanbaku','gudang_cabang_models.id')
        ->join('satuan_models','purch_prod_models.id_satuan','satuan_models.id')
        ->where('purch_prod_models.no_purchase',$no)
        ->select('purch_prod_models.id',
        'purch_prod_models.no_purchase',
        'gudang_cabang_models.nama_barang',
        'purch_prod_models.berat',
        'satuan_models.nama_satuan',
        'purch_prod_models.harga',
        'purch_prod_models.quantity',
        'purch_prod_models.sub_total',
        'purch_prod_models.status'
        )
        ->orderBy('purch_prod_models.id','desc')
        ->get();
        // dd($pu);
        return view('purprod.detailprod',compact('purc','tampil','tampil2','no','qtyawal'));
    }
    public function print($id){

        $purc = Purchase::find($id);
        $no = $purc->no_purchase;
        $tgl = $purc->tanggal_purchase;
        $big_total = $purc->big_total;
        $bayar = $purc->bayar;
        $sisa = $purc->sisa;
        $due_date = $purc->due_date;
        $user = Purchase::join('cabang','purchases.cabang_peminta','cabang.id')
                                ->where('no_purchase',$no)
                                ->select(
                                'cabang.nama_cabang')
                                ->get();
        
        $tampil2 = $purc->big_total;
        // $tampil = PurchaseModel::where('no_purchase','er')->get();
        $qtyawal = $purc->quantity;
        
        $tampil = DetailPurchase::join('barang_gudangs','detail_purchases.code_barang_model','barang_gudangs.code_barang_model')
        ->join('satuan_models','detail_purchases.id_satuan','satuan_models.id')
        ->where('detail_purchases.no_purchase',$no)
        ->where('detail_purchases.status','=',"ready")
        ->select('detail_purchases.id',
        'detail_purchases.no_purchase',
        'barang_gudangs.nama_barang',
        'detail_purchases.berat',
        'satuan_models.nama_satuan',
        'detail_purchases.harga_jual',
        'detail_purchases.quantity',
        'detail_purchases.sub_total_jual',
        'detail_purchases.status'
        )
        ->orderBy('detail_purchases.id','desc')
        ->get();
        // dd($pu);
        return view('purchase.print',compact('user','purc','tampil','tampil2','no','qtyawal','user','tgl','big_total','bayar','sisa','due_date'));
    }
    public function printpaid($id){

        $purc = PurchasingModel::find($id);
        $no = $purc->no_purchase;
        $tgl = $purc->tanggal_purchase;
        $big_total = $purc->big_total;
        $bayar = $purc->bayar;
        $sisa = $purc->sisa;
        $due_date = $purc->due_date;
        $user = PurchasingModel:: join('cabang','purchasing_models.cabang_pembuat','cabang.id')
                                ->where('no_purchase',$no)
                                ->select(
                                'cabang.nama_cabang')
                                ->get();
        $detailbayar = PembayaranpurchModel::where('no_purchase',$no)->get();
        
        // $tampil2 = $purc->big_total;
        // $tampil = PurchaseModel::where('no_purchase','er')->get();
        // $qtyawal = $purc->quantity;
        
        // $tampil = PurchaseModel::join('bahanbaku','purchase_models.id_bahanbaku','bahanbaku.id')
        // ->join('satuan_models','purchase_models.id_satuan','satuan_models.id')
        // ->where('purchase_models.no_purchase',$no)
        // ->select('purchase_models.id',
        // 'purchase_models.no_purchase',
        // 'bahanbaku.nama_bahanbaku',
        // 'purchase_models.berat',
        // 'satuan_models.nama_satuan',
        // 'purchase_models.harga',
        // 'purchase_models.quantity',
        // 'purchase_models.sub_total',
        // 'purchase_models.status',
        // 'purchase_models.status'
        // )
        // ->orderBy('purchase_models.id','desc')
        // ->get();
        // dd($pu);
        return view('payment.print',compact('detailbayar','purc','no','user','tgl','big_total','bayar','sisa','due_date'));
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
    public function editqty($id){
        $qty = DetailPurchase::find($id);
        $no  = $qty->no_purchase;
        $qtyawal = $qty->quantity;
        $tampil = DetailPurchase::join('barang_gudangs','detail_purchases.id_barang','barang_gudangs.id')
        ->join('satuan_models','detail_purchases.id_satuan','satuan_models.id')
        ->where('detail_purchases.no_purchase',$no)
        ->select('detail_purchases.id','detail_purchases.no_purchase',
        'barang_gudangs.nama_barang',
        'detail_purchases.berat',
        'satuan_models.nama_satuan',
        'detail_purchases.harga',
        'detail_purchases.quantity',
        'detail_purchases.sub_total',
        'detail_purchases.status'
        )
        ->get();
        $tampil2 = DetailPurchase::where('no_purchase',$no)->where('status','=','ready')->sum('sub_total_jual');
        // dd($no);
        return view('purchase.edit',compact('qty','no','qtyawal'));
    }

    public function aksieditqty(Request $request,$id){
        $qua = DetailPurchase::find($id);
        $no  = $qua->no_purchase;
        $no_purchase = Purchase::where('no_purchase',$no)->get();
        $newqty = $request->quantity;
        $harpok = $qua->harga_pokok;
        $newsub = $qua->harga_jual;
        $subtot = $newqty*$newsub;
        $subpok = $harpok*$newqty;
        $qua->update(['quantity'=>"$newqty",
        'sub_total_pokok'=>"$subpok",
        'sub_total_jual'=>"$subtot"]);
        // $tampil = PurchaseModel::join('bahanbaku','purchase_models.id_bahanbaku','bahanbaku.id')
        // ->join('satuan_models','purchase_models.id_satuan','satuan_models.id')
        // ->where('purchase_models.no_purchase',$no)
        // ->select('purchase_models.id','purchase_models.no_purchase',
        // 'bahanbaku.nama_bahanbaku',
        // 'purchase_models.berat',
        // 'satuan_models.nama_satuan',
        // 'purchase_models.harga',
        // 'purchase_models.quantity',
        // 'purchase_models.sub_total',
        // 'purchase_models.status'
        // )
        // ->get();
        // $tampil2 = PurchaseModel::where('no_purchase',$no)->where('status','=','ready')->sum('sub_total');
        
        // dd($subtot);
        return back();
        // return view('purchase.detail',compact('tampil','tampil2','qua','no','no_purchase','newqty','newsub','subtot'));
    }

    public function approval($id){
        $tampil = DetailPurchase::find($id);
        $id = $tampil->id;
        $no = $tampil->no_purchase;
        $harga_pk = $tampil->harga_pokok;
        $harga_up = $tampil->harga_jual;
        $qty = $tampil->quantity;
        $subtotal = $tampil->sub_total_jual;
        $nama_gudang = $tampil->nama_gudang;
        $id_bahanbaku = $tampil->code_barang_model;
        $tampil->update(['status' => "ready"]);
        $tampil2 = DetailPurchase::where('no_purchase',$no)->where('status','=','ready')->sum('sub_total_jual');
        
        $ubah = Purchase::where('no_purchase',$no)->update(['big_total'=> $tampil2,'sisa' => DB::raw('big_total')]);
        // dd($ubah);
        $input = new KeuntunganModel();
        $input->no_purchase = $no;
        $input->id_purchase = $id;
        $input->id_bahanbaku = $id_bahanbaku;
        $input->harga_pk = $harga_pk;
        $input->harga_up = $harga_up;
        $input->quantity = $qty;
        $sub_pk = $harga_pk * $qty;
        $input->sub_totalpk = $sub_pk;
        $input->sub_total = $subtotal;
        $input->nama_gudang = $nama_gudang;
        $input->save();

        
        $up = BarangGudang::where('id',$id_bahanbaku)->update([
            'stok'=> DB::raw("stok - $qty"),
            'sub_total_jual'=> DB::raw("harga_jual * stok"),
            'sub_total_pokok'=> DB::raw("harga_pokok * stok")
        
        ]);
        
        // dd($tampil);
        return redirect()->back();
    }

    public function tidaktersedia($id){
        $tampil = DetailPurchase::find($id);
        $tampil->update(['status' => "Tidak Tersedia"]);
       
        // dd($tampil2);
        return redirect()->back();
    }

    public function receive($id){
        $tampil = DetailPurchase::find($id);
        $no = $tampil->no_purchase;
        $tampil->update(['status' => "receive"]);
        
        // dd($ubah);
        return redirect()->back();
    }
    public function return($id){
        $tampil = DetailPurchase::find($id);
        $id = $tampil->id;
        $no = $tampil->no_purchase;
        $id_barang = $tampil->code_barang_model;
        $qty = $tampil->quantity;
        $nama_gudang = $tampil->nama_gudang;
        $date = date('Y-m-d H:i:s');

        $tampil->update(['status' => "return"]);
        $tampil2 = DetailPurchase::where('no_purchase',$no)->where('status','=','ready')->sum('sub_total');
        $delete = KeuntunganModel::where('id_purchase',$id)->update(['quantity' => "0",'sub_total' => "0",'sub_totalpk' => "0"]);
        $ubah = Purchase::where('no_purchase',$no)->update(['big_total' => $tampil2,'sisa' => $tampil2]);
        // foreach($tampil as $tam){
        //     $ta
        // }
        $input = BarangreturnhModel::insert(['no_purchase'=>$no,'id_barang'=>$id_barang,'qty'=>$qty,'status'=>"return",'nama_gudang'=>$nama_gudang,'created_at'=>$date]);
        // dd($ubah);
        // dd($date);
        return redirect()->back();
    }

    public function restok($id){
        $tampil = BarangreturnhModel::find($id);
        $no = $tampil->code_barang_model;
        $qty = $tampil->qty;
        $tampil->update(['status' => "back to stok"]);
        $ubah = BarangGudang::where('code_barang_model',$no)->update(['stok'=> DB::raw("stok + $qty")]);
        
        // dd($ubah);
        return redirect()->back();
    }
    public function bayarprod(Request $request,$id){
        $cari = InvPurchProdModel::find($id);
        $nopur = $cari->no_purchase;
        $sisa = $cari->sisa;

        return view('purprod.bayarprod',compact('cari','nopur','sisa'));
    }
    
    public function inputbayarprod(Request $request){
        $input = new PayProdModel();
        $input->no_purchase = $request->no_purchase;
        $input->nominal = $request->nominal;
        $input->save();
        $no_purchase = $request->no_purchase;
        $nominal = $request->nominal;
        $bayar = PayProdModel::where('no_purchase',$no_purchase)->sum('nominal');

        $up = InvPurchProdModel::where('no_purchase',$no_purchase)->update([
            'bayar'=> $bayar,'sisa' => DB::raw("sisa - $nominal")
        ]);
        // dd($up);
        return back()->with('success', 'Record Created Successfully.');
    }
    public function bayar(Request $request,$id){
        $find = Purchase::find($id);
        $no_purch = $find->no_purchase;
        $sisa = $find->sisa;
        // dd($no_purch);
        return view('bayar.create',compact('find','no_purch','sisa'));
    }
    public function detailpayment($id){
        $purc = Purchase::find($id);
        $no = $purc->no_purchase;
        $sisa = $purc->sisa;
        // $tampil = PurchaseModel::where('no_purchase','er')->get();
    
    
        $tampil = PembayaranpurchModel::where('no_purchase',$no)->get();
        $tampil2 = PembayaranpurchModel::where('no_purchase',$no)->sum('nominal');
        return view('payment.detailbayar',compact('purc','no','tampil','tampil2','sisa'));
    }

    public function detailbayar($id){
        $purc = Purchase::find($id);
        $no = $purc->no_purchase;
        $sisa = $purc->sisa;
        // $tampil = PurchaseModel::where('no_purchase','er')->get();
    
    
        $tampil = PembayaranpurchModel::where('no_purchase',$no)->get();
        $tampil2 = PembayaranpurchModel::where('no_purchase',$no)->sum('nominal');
        // dd($no);
        return view('purchase.detailbayar',compact('purc','no','tampil','tampil2','sisa'));
    }
    public function detailbayarin($id){
        $purc = Purchase::find($id);
        $no = $purc->no_purchase;
        // $tampil = PurchaseModel::where('no_purchase','er')->get();
    
    
        $tampil = PembayaranpurchModel::where('no_purchase',$no)->get();
        $tampil2 = PembayaranpurchModel::where('no_purchase',$no)->sum('nominal');
        $sisa = Purchase::where('no_purchase',$no)->sum('sisa');
        // dd($no);
        return view('purchase.detailbayarin',compact('purc','no','tampil','tampil2','sisa'));
    }
    public function inputbayar(Request $request){
        $input = new PembayaranpurchModel();
        $input->no_purchase = $request->no_purchase;
        $input->nominal = $request->nominal;
        $input->save();
        $no_purchase = $request->no_purchase;
        $nominal = $request->nominal;
        $bayar = PembayaranpurchModel::where('no_purchase',$no_purchase)->sum('nominal');

        $up = Purchase::where('no_purchase',$no_purchase)->update([
            'bayar'=> $bayar,'sisa' => DB::raw("sisa - $nominal")
        ]);
        // dd($up);
        return back()->with('success', 'Record Created Successfully.');
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
