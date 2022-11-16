<?php

namespace App\Http\Controllers;

use App\CartModel;
use App\IntiKomponenModel;
use App\ItemModel;
use App\KomponenModel;
use App\PaketModel;
use App\StokRetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    
    public function tampil(){
        
        $product = PaketModel::join('komponen_models','paket_models.id_komponen','komponen_models.id')
        ->select('paket_models.id',
        'paket_models.id_komponen',
        'paket_models.nama_paket',
        'paket_models.hpp',
        'paket_models.harga_jual',
        'paket_models.gambar',
        'paket_models.cabang_id')
        ->get();
        foreach($product as $pro){
            $komponen = $pro->id_komponen;  
        }
        $inti = IntiKomponenModel::where('id',$komponen)->get();
        foreach($inti as $in){
            $nama = $in->nama_komponen;
        }
        // dd($inti);
        $kom = KomponenModel::join('item_models','komponen_models.id_item','item_models.id')
        ->where('nama_komponen',$nama)
        ->select('item_models.nama_item','komponen_models.harga_jual','item_models.gambar')
        ->get();
        $auth = Auth::user()->cabang_id;
        $user = Auth::user()->id;
        $sum = CartModel::where('cabang_id',$auth)->where('id_user',$user)->sum('subtotal');
        $sum2 = CartModel::where('cabang_id',$auth)->where('id_user',$user)->sum('qty');
        // dd($komponen);
        return view('kasir/tampil',compact('kom','product','komponen','inti','auth','sum','sum2'));
    }

    public function cataloge(){
        $user = Auth::user()->cabang_id;
        $stok = StokRetailModel::join('item_models','stok_retail_models.id_product','item_models.id')
        ->where('stok_retail_models.cabang_id',$user)
        ->select(
            'stok_retail_models.id',
            'item_models.nama_item',
            'stok_retail_models.hpp',
            'stok_retail_models.harga_jual',
            'stok_retail_models.stok',
            'stok_retail_models.sub_total',
            'stok_retail_models.sub_totalpk',
            'item_models.gambar'
        )
        ->get();
        $auth = Auth::user()->cabang_id;
        $users = Auth::user()->id;
        $sum = CartModel::where('cabang_id',$auth)->where('id_user',$users)->sum('subtotal');
        $sum2 = CartModel::where('cabang_id',$auth)->where('id_user',$users)->sum('qty');
        // dd($komponen);
        return view('kasir/cataloge',compact('user','stok','auth','users','sum','sum2'));
    }

    public function detail($id){
        $product = PaketModel::
        find($id);
        $komponen = $product->id_komponen;
        $inti = IntiKomponenModel::where('id',$komponen)->get();
        foreach($inti as $in){
            $nama = $in->nama_komponen;
        }
        // dd($inti);
        $kom = KomponenModel::join('item_models','komponen_models.id_item','item_models.id')
        ->where('nama_komponen',$nama)
        ->select('item_models.nama_item','komponen_models.harga_jual','item_models.gambar')
        ->get();
        // dd($kom);
        return view('kasir.detail',compact('kom','product','komponen','inti'));
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
