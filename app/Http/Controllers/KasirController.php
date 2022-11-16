<?php

namespace App\Http\Controllers;

use App\CartModel;
use App\IntiKomponenModel;
use App\ItemModel;
use App\Provinces;
use App\Regencies;
use App\Disctricts;
use App\CartItem;
use App\Villages;
use App\KomponenModel;
use App\PaketModel;
use App\StokRetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DB;

class KasirController extends Controller
{
    public function provinces()
    {
        return \Indonesia::allProvinces();
    }

    public function cities(Request $request)
    {
        return \Indonesia::allCities();
    }

    public function districts(Request $request)
    {
        return \Indonesia::findCity($request->id, ['districts'])->districts->pluck('name', 'id');
    }

    public function villages(Request $request)
    {
        return \Indonesia::findDistrict($request->id, ['villages'])->villages->pluck('name', 'id');
    }
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
        $cabang = Auth::user()->cabang_id;
        
        $product = PaketModel::join('komponen_models','paket_models.id_komponen','komponen_models.id')
        ->where('cabang_id',$cabang)
        ->select('paket_models.id',
        'paket_models.id_komponen',
        'paket_models.nama_paket',
        'paket_models.hpp',
        'paket_models.harga_jual',
        'paket_models.gambar',
        'paket_models.cabang_id')
        ->get();
        // foreach($product as $pro){
        //     $komponen = $pro->id_komponen;  
        // }
        // $inti = IntiKomponenModel::where('id',$komponen)->get();
        // foreach($inti as $in){
        //     $nama = $in->nama_komponen;
        // }
        // // dd($inti);
        // $kom = KomponenModel::join('item_models','komponen_models.id_item','item_models.id')
        // ->where('nama_komponen',$nama)
        // ->select('item_models.nama_item','komponen_models.harga_jual','item_models.gambar')
        // ->get();
        // $auth = Auth::user()->cabang_id;
        // $user = Auth::user()->id;
        // $sum = CartModel::where('cabang_id',$auth)->where('id_user',$user)->sum('subtotal');
        // $sum2 = CartModel::where('cabang_id',$auth)->where('id_user',$user)->sum('qty');
        // dd($product);
        return view('kasir/tampil',compact('product'));
    }

    public function cataloge(){
        $user = Auth::user()->cabang_id;
        // $stok = StokRetailModel::join('item_models','stok_retail_models.id_product','item_models.id')
        // ->where('stok_retail_models.cabang_id',$user)
        // ->select(
        //     'stok_retail_models.id',
        //     'item_models.nama_item',
        //     'stok_retail_models.hpp',
        //     'stok_retail_models.harga_jual',
        //     'stok_retail_models.stok',
        //     'stok_retail_models.sub_total',
        //     'stok_retail_models.sub_totalpk',
        //     'item_models.gambar'
        // )
        // ->get();
        // $auth = Auth::user()->cabang_id;
        // $users = Auth::user()->id;
        // $sum = CartModel::where('cabang_id',$auth)->where('id_user',$users)->sum('subtotal');
        // $sum2 = CartModel::where('cabang_id',$auth)->where('id_user',$users)->sum('qty');
        $date = new DateTime();
        $req = ItemModel::select('code_item')->orderby('created_at','desc')->first();

        if($req != null){
            $bulan = $date->format('m');
            $bulanreq = substr($req->code_master,6,2);
            if($bulan == $bulanreq){
                $pcod = substr($req->code_master,13);
                $codplus = (int)$pcod + 1;
                $codigit = sprintf("%05s",$codplus);
                $kode = 'INV'.$user.'-'.$date->format('dm/His');
            }else{
                $kode = 'INV'.$user.'-'.$date->format('dm/His');
            }
        }else{
            $kode = 'INV'.$user.'-'.$date->format('dm/His');
        }
        $product = PaketModel::where('cabang_id',$user)
        ->get();
        $komponen = KomponenModel::join('item_models','komponen_models.id_item','item_models.id')
        ->select('item_models.id',
                'komponen_models.code_komponen',
                'item_models.nama_item')
                ->get();
        
        $item = ItemModel::where('cabang_id',$user)->OrderBy('nama_item','asc')
        ->get();
        $id_user = Auth::user()->id;
        $cart = CartModel::join('paket_models','cart.id_paket','paket_models.id')
        ->where('id_user',$id_user)
        ->select('cart.id',
                'paket_models.nama_paket',
                'cart.id_paket',
                'cart.qty',
                'cart.hpp',
                'cart.harga',
                'cart.disc',
                'cart.cut_sale',
                'cart.subhpp',
                'cart.subtotal',
                'cart.cabang_id')
                ->get();
        // dd($cart);
        $big = CartModel::where('id_user',$id_user)
        ->sum('subtotal');
        $bighpp = CartModel::where('id_user',$id_user)
        ->sum('subhpp');
        // $regency = Regencies::all();
        // dd($product);

        return view('kasir/cataloge',compact('item','product','req','kode','cart','big','bighpp','komponen'));
    }

    public function detail($id){
        // $product = PaketModel::
        // find($id);
        // $komponen = $product->id_komponen;
        // $inti = IntiKomponenModel::where('id',$komponen)->get();
        // foreach($inti as $in){
        //     $nama = $in->nama_komponen;
        // }
        // // dd($inti);
        // $kom = KomponenModel::join('item_models','komponen_models.id_item','item_models.id')
        // ->where('nama_komponen',$nama)
        // ->select('item_models.nama_item','komponen_models.harga_jual','item_models.gambar')
        // ->get();
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
    public function deletbar(Request $request){
        $id = $request->id;
        $cart = CartModel::where('id',$id)->get();
        
        foreach($cart as $carts){
            $id_paket = $carts->id_paket;
            // dd($id_paket);
            $aut = Auth::user()->id;
            $hapus = CartItem::where('id_paket',$id_paket)->where('id_user',$aut)->delete();
            // dd($hapus);
        }
        $delete  = CartModel::where('id',$id)->delete();
       
       
        return back()->with('succes','Product Masuk Keranjang');
    }
    public function editqu(Request $request){
        $aut = Auth::user()->id;
        $id = $request->id;
        $id_paket = $request->id_paket;
        $hpp =  $request->hpp;
        $harga = $request->harga;
        $qty  = $request->qty;
        $disc = $request->disc;
        $dishpp  = (($hpp * $qty) * $disc/100);
        $disju   = (($harga * $qty) * $disc/100);
        $cut  = $request->cutsale;
        $cutsale =  $qty * $cut;
        if($disc > 0){
              $cart = CartModel::where('id',$id)->update(['qty'=> $qty,'subhpp' => DB::raw("(hpp * $qty) - $dishpp"),'subtotal' => DB::raw("(harga * $qty) - $disju")]);
              $hapus = CartItem::where('id_paket',$id_paket)->where('id_user',$aut)->update(['qty' => $qty,'subhpp' => DB::raw("(hpp * $qty) - $dishpp"),'subtotal' => DB::raw("(harga * $qty) - $disju")]);
        }
        elseif($cut > 0){
            $cart = CartModel::where('id',$id)->update(['qty'=> $qty,'subhpp' => DB::raw("(hpp * $qty) - $cutsale"),'subtotal' => DB::raw("(harga * $qty) - $cutsale")]);
            $hapus = CartItem::where('id_paket',$id_paket)->where('id_user',$aut)->update(['qty' => $qty,'subhpp' => DB::raw("(hpp * $qty) - $cutsale"),'subtotal' => DB::raw("(harga * $qty) - $cutsale")]);

        }
        else{
            $cart = CartModel::where('id',$id)->update(['qty'=> $qty,'subhpp' => DB::raw("hpp * $qty"),'subtotal' => DB::raw("harga * $qty")]);
            $hapus = CartItem::where('id_paket',$id_paket)->where('id_user',$aut)->update(['qty' => $qty,'subhpp' => DB::raw("hpp * $qty"),'subtotal' => DB::raw("harga * $qty")]);
        }
    
       
        return back()->with('succes','Product Masuk Keranjang');
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
