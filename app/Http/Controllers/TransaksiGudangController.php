<?php

namespace App\Http\Controllers;

use App\CabangModel;
use App\CartTransaksiGudangModel;
use App\InvoiceTransaksiGudangModel;
use App\InvoicingTransaksiGudangModel;
use App\IsiTransaksiGudangModel;
use App\SatuanBarangModel;
use App\BarangGudang;
use App\SatuanModel;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TransaksiGudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cabang = Auth::user()->cabang_id;
        $invoicing = InvoicingTransaksiGudangModel::where('cabang_id',$cabang)
        ->orderBy('id','desc')
        ->get();
        return view('gudang/transaksi',compact('cabang','invoicing'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $us = Auth::user()->hak_akses;
        $use = Auth::user()->id;
        $barang = BarangGudang::join('satuan_models','barang_gudangs.id_satuan','satuan_models.id')
        ->where('barang_gudangs.nama_gudang',$us)
        ->where('stok','>',"1")
        ->select('barang_gudangs.id',
                'barang_gudangs.code_barang_model',
                'barang_gudangs.nama_barang',
                'barang_gudangs.harga_pokok',
                'barang_gudangs.harga_jual',
                'barang_gudangs.berat',
                'barang_gudangs.stok',
                'barang_gudangs.sub_total_jual',
                'satuan_models.nama_satuan')
                ->get();
        
        $cart  = CartTransaksiGudangModel::join('barang_gudangs','cart_transaksi_gudang_models.id_barang','barang_gudangs.id')
        ->join('satuan_models','barang_gudangs.id_satuan','satuan_models.id')
        ->where('cart_transaksi_gudang_models.user_id',$use)
        ->select('barang_gudangs.nama_barang',
                'cart_transaksi_gudang_models.id',
                'cart_transaksi_gudang_models.harga_pk',
                'cart_transaksi_gudang_models.harga_up',
                'cart_transaksi_gudang_models.qty',
                'cart_transaksi_gudang_models.sub_total',
                'satuan_models.nama_satuan')
                ->get();
        $big_total = CartTransaksiGudangModel::where('user_id',$use)
        ->sum('sub_total');
        $cabang = CabangModel::all();
        $date = new DateTime();
        $ldate = date('Y-m-d');
        $cabang1 = "INV";
        $req = InvoicingTransaksiGudangModel::select('no_invoice')->orderby('created_at','desc')->first();

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
        // dd($use);
        return view('gudang.transak',compact('barang','cart','big_total','req','date','kode','us'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request){
        $id_user =  Auth::user()->id;
        $cabang_id = Auth::user()->cabang_id;
        $id      = $request->id;
        $harga_pk   = $request->harga_pokok;
        $hargaup = $request->harga_jual;
        $qty     = $request->qty;
        $discount = $request->disc;
        $cutsale  = $request->cut_sale;
        $hitung1= $harga_pk*$qty;
        $hitung2 = $hargaup*$qty;
        // dd($hitung1);
        

        if($discount > 0){
            $discounts = $hitung1 * ($discount/100);
            $discountss = $hitung2 * ($discount/100);
            $subtotal = $hitung1 - $discounts;
            $subtotalup = $hitung2 - $discount;
        }
        elseif($cutsale > 0){
            $subtotal = $hitung1 - $cutsale;
            $subtotalup = $hitung2 - $cutsale;
        }
        else{
            $subtotal = $hitung1;
            $subtotalup = $hitung2;
        }
        $cek = CartTransaksiGudangModel::where('id_barang',$id)->count();
        $stok = BarangGudang::where('id',$id)->select('stok')->get();
        foreach($stok as $stoks){
            $skt = $stoks->stok;
        }
        if($cek){
            // if($skt < $qty){
            //     // return with('succes','stok habis');
            // }
            // else{
                $input = CartTransaksiGudangModel::where('id_barang',$id)->update([
                    'qty' => DB::raw("qty + $qty"),
                ]);
                $gudangs = BarangGudang::where('id',$id)->update(['stok' => DB::raw("stok - $qty")]);
            // }
            
            if($discount > 0){
                $input = CartTransaksiGudangModel::where('id_barang',$id)->update([
                    'sub_total' => DB::raw("(harga_up * qty) - $discounts"),
                ]);
            }
            elseif($cutsale > 0){
                $input = CartTransaksiGudangModel::where('id_barang',$id)->update([
                    'sub_total' => DB::raw("(harga_up * qty) - $cutsale"),
                ]);
            
            }
            else{
                $input = CartTransaksiGudangModel::where('id_barang',$id)->update([
                    'sub_total' => DB::raw("harga_up * qty"),
                ]);
            }

        }
        else{
            // if($skt < $qty){
            //     // return with('succes','stok habis');
            // }
            // else{
            $masukan = CartTransaksiGudangModel::insert([
                'user_id'   => $id_user,
                'cabang_id' => $cabang_id,
                'id_barang' => $id,
                'harga_pk'  => $harga_pk,
                'harga_up'  => $hargaup,
                'qty'       => $qty,
                'discount'  => $discount,
                'cut_sale'   => $cutsale,
                'sub_total'  => $subtotalup

            ]);
            $gudangs = BarangGudang::where('id',$id)->update(['stok' => DB::raw("stok - $qty")]);
        // }
            
        }

        return back()->with('succes','Product Masuk Keranjang');

    }
    public function invoicing(Request $request){
        $id_user = Auth::user()->id;
        $namane = Auth::user()->name;
        $cabang  = Auth::user()->cabang_id;
        $invoice = $request->no_invoice;
        $bayar   = $request->bayar;
        $cart = CartTransaksiGudangModel::where('user_id',$id_user)->get();
        $big_total = CartTransaksiGudangModel::where('user_id',$id_user)->sum('sub_total');
        
        // dd($invoice);
        foreach($cart as $carts){
            $ceks = InvoicingTransaksiGudangModel::where('no_invoice',$invoice)->count();
            if($ceks){

            }
            else{
                $input = new InvoiceTransaksiGudangModel();
                $input->no_invoice = $request->no_invoice;
                $input->id_barang = $carts->id_barang;
                $idbarang = $carts->id_barang;
                $input->harga_pk  = $carts->harga_pk;
                $input->harga_up  = $carts->harga_up;
                $input->qty       = $carts->qty;
                $qtyc = $carts->qty;
                $input->discount  = $carts->discount;
                $input->cut_sale  = $carts->cut_sale;
                $input->sub_total = $carts->sub_total; 
                $input->cabang_id = $carts->cabang_id; 
                $input->save();

                // foreach($cart->id_barang as $key => $value){
                //     $masuk = new IsiTransaksiGudangModel();
                //     $masuk->no_invoice = $request->no_invoice;
                //     $masuk->id_barang = $value;
                //     $masuk->harga_pk =  $cart->harga_pk[$key];
                //     $masuk->harga_up =  $cart->harga_up[$key];
                //     $masuk->qty = $cart->qty[$key];
                //     $qtyc = $cart->qty[$key];
                //     $masuk->discount = $cart->discount[$key];
                //     $masuk->cut_sale = $cart->cut_sale[$key];
                //     $masuk->sub_total = $cart->sub_total[$key];
                //     $masuk->tanggal_transaksi = date('Y-m-d');
                //     $masuk->save();
                // }
                // dd($qtyc);
                
            
            }
      
        }
        $cek = InvoicingTransaksiGudangModel::where('no_invoice',$invoice)->count();
        if($cek){
            
        }
        else{
            InvoicingTransaksiGudangModel::create([
                'no_invoice'  => $invoice,
                'cabang_id'   => $cabang,
                'id_user'     => $id_user,
                'tanggal_transaksi'  => date('Y-m-d'),
                'big_total'   => $big_total,
                'bayar'       => $bayar,
                'sisa'        => ($bayar - $big_total),
                'status'      => "ok" 
            ]);
            
        }
        
        $print = InvoicingTransaksiGudangModel::where('id_user',$id_user)
        ->where('no_invoice',$invoice)
        ->select('no_invoice',
                'tanggal_transaksi',
                'id_user',
                'big_total',
                'bayar',
                'sisa')
                ->get();
        $loopbarang = InvoiceTransaksiGudangModel::join('barang_gudangs','invoice_transaksi_gudang_models.id_barang','barang_gudangs.id')
                    ->join('satuan_models','barang_gudangs.id_satuan','satuan_models.id')
                    ->where('no_invoice',$invoice)
                    ->select('barang_gudangs.nama_barang'
                    ,'barang_gudangs.harga_jual'
                    ,'barang_gudangs.berat'
                    ,'invoice_transaksi_gudang_models.qty'
                    ,'invoice_transaksi_gudang_models.sub_total',
                    'satuan_models.nama_satuan')
                    ->orderBy('barang_gudangs.id','desc')
                    ->get();
        $invo = InvoiceTransaksiGudangModel::where('no_invoice',$invoice)->get();
        foreach($invo as $invos){
            $barangs = $invos->id_barang;
            $cabangs = $invos->cabang_id;
            $qtys    = $invos->qty;
        }
        $hapus = CartTransaksiGudangModel::where('user_id',$id_user)
        ->delete();
        // dd($invo);
        return view('gudang/print',compact('invoice','namane','print','hapus','loopbarang'));

        // return view('gudang.transak');
    }

    public function remove(Request $request)
    {
        
        $id = $request->id;
        $get = CartTransaksiGudangModel::where('id',$id)->get();
        foreach($get as $gets){
            $idbarang = $gets->id_barang;
            $qty = $gets->qty;
        }
        // dd($qty);    
        $back = BarangGudang::where('id',$idbarang)->update(['stok' => DB::raw("stok + $qty")]);
        $delete  = CartTransaksiGudangModel::where('id',$id)->delete();
        
        return back()->with('succes','Product Masuk Keranjang');
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
    public function print($id){
        $print = InvoicingTransaksiGudangModel::find($id);
        $id    = $print->id;
        $big_total = $print->big_total;
        $no_invoice = $print->no_invoice;
        $bayar = $print->bayar;
        $sisa = $print->sisa;
        $tanggal = $print->tanggal_transaksi;
        $tampil = InvoiceTransaksiGudangModel::join('barang_gudangs','invoice_transaksi_gudang_models.id_barang','barang_gudangs.id')
        ->where('no_invoice',$no_invoice)
        ->select('invoice_transaksi_gudang_models.no_invoice'
                 ,'barang_gudangs.nama_barang'
                 ,'invoice_transaksi_gudang_models.harga_pk'
                 ,'invoice_transaksi_gudang_models.harga_up'
                 ,'invoice_transaksi_gudang_models.qty'
                 ,'invoice_transaksi_gudang_models.discount'
                 ,'invoice_transaksi_gudang_models.cut_sale'
                 ,'invoice_transaksi_gudang_models.sub_total')
                 ->get();
        // dd($tampil);
        return view('gudang.printgud',compact('print','id','no_invoice','tampil','big_total','tanggal','bayar','sisa'));
    }

    public function detail($id){
        $print = InvoicingTransaksiGudangModel::find($id);
        $id    = $print->id;
        $big_total = $print->big_total;
        $no_invoice = $print->no_invoice;
        $tampil = InvoiceTransaksiGudangModel::join('barang_gudangs','invoice_transaksi_gudang_models.id_barang','barang_gudangs.id')
        ->where('no_invoice',$no_invoice)
        ->select('invoice_transaksi_gudang_models.no_invoice'
                 ,'barang_gudangs.nama_barang'
                 ,'invoice_transaksi_gudang_models.harga_pk'
                 ,'invoice_transaksi_gudang_models.harga_up'
                 ,'invoice_transaksi_gudang_models.qty'
                 ,'invoice_transaksi_gudang_models.discount'
                 ,'invoice_transaksi_gudang_models.cut_sale'
                 ,'invoice_transaksi_gudang_models.sub_total')
                 ->get();
        // dd($tampil);
        return view('gudang.gudangdetails',compact('print','id','no_invoice','tampil','big_total'));
    }

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
        
    }
}
