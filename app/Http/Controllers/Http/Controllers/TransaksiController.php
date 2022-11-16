<?php

namespace App\Http\Controllers;

use App\CartModel;
use App\CekoutModel;
use App\PaketModel;
use App\StokRetailModel;
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

    public function addtocart(Request $request)
    {
        $aut = Auth::user()->cabang_id;
        $user = Auth::user()->id;
        $id = $request->id_paket;
        $harga = $request->harga_jual;
        $disc = $request->disc;
        $cut = $request->cut_sale;
        $qty = $request->qty;
        $dis = (($harga*$qty)*($disc/100));
       
        
        // dd($sb);
        $cek = CartModel::where('id_paket',$id)->where('cabang_id',$aut)->count();
        // dd($cek);
        if($cek){
            $up = CartModel::where('id_paket',$id)->update([
                'qty'=> DB::raw("qty + $qty"),
                'subtotal'=> DB::raw("qty * harga")
                
            ]);
            }
            else{
                $hust = CartModel::insert(['id_paket'=>$id,'harga'=>$harga,'qty'=>$qty,'disc'=>$disc,'cut_sale'=>$cut,'subtotal'=>$qty*$harga,'cabang_id'=>$aut,'id_user'=>$user]);
            }
            $kurangi = StokRetailModel::where('id_product',$id)->update([
                'stok'=> DB::raw("stok - $qty"),
                'sub_total' => DB::raw("hpp * stok"),
                'sub_totalpk' => DB::raw("harga_jual * stok")
            ]);
            
        // dd($cek);

        return back()->with('succes','Product Masuk Keranjang');
    }

    public function cekoutnew(){

        $user = Auth::user()->id;
        $cek = CartModel::join('paket_models','cart.id_paket','paket_models.id')
        ->where('id_user',$user)
        ->select('cart.id',
                'paket_models.nama_paket',
                'cart.qty',
                'cart.harga',
                'cart.disc',
                'cart.cut_sale',
                'cart.subtotal',
                'cart.id_user')
                ->get();
        $sum = CartModel::where('id_user',$user)->sum('subtotal');
        // dd($cek);
        $date = new DateTime();
        $ldate = date('Y-m-d');
        $cabang1 = "INV";
        $req = CekoutModel::select('no_inv')->orderby('created_at','desc')->first();

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

        return view('kasir/cekoutnew',compact('user','cek','sum','date','ldate','cabang1','req','kode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
