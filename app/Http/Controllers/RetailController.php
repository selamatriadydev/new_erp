<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InventoryRetail;
use App\ItemModel;
use App\CartRetail;
use App\CabangModel;
use App\TransaksiRetail;
use App\DetailRetail;
use App\ReturnRetail;
use App\BonusRetail;
use DateTime;
use Auth;
use DB;
class RetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cabang = Auth::user()->cabang_id;
        $retail = InventoryRetail::join('item_models','inventory_retails.code_item','item_models.code_item')
        ->where('inventory_retails.cabang_id',$cabang)
        ->select('inventory_retails.id',
                'inventory_retails.code_item',
                'inventory_retails.id_item',
                'item_models.nama_item',
                'inventory_retails.harga_pk',
                'inventory_retails.margin',
                'inventory_retails.harga_up',
                'inventory_retails.stok',
                'inventory_retails.subtotal_pk',
                'inventory_retails.subtotal_up',
                'item_models.gambar')
                ->orderBy('inventory_retails.id','asc')
        ->get();

        return view('retail/index',compact('retail','cabang'));
    }

    public function pos(){

        $cabang = Auth::user()->cabang_id;
        $user = Auth::user()->id;
        $retail = InventoryRetail::join('item_models','inventory_retails.code_item','item_models.code_item')
        ->where('inventory_retails.cabang_id',$cabang)
        ->select('inventory_retails.id',
                'inventory_retails.code_item',
                'item_models.nama_item',
                'inventory_retails.harga_pk',
                'inventory_retails.margin',
                'inventory_retails.harga_up',
                'inventory_retails.stok',
                'inventory_retails.subtotal_pk',
                'inventory_retails.subtotal_up',
                'item_models.gambar')
        ->get();
        $cart  =  CartRetail::join('item_models','cart_retails.code_item','item_models.code_item')
        ->where('cart_retails.user_id',$user)
        ->select('cart_retails.id',
                'cart_retails.code_item',
                'item_models.nama_item',
                'cart_retails.harga_pk',
                'cart_retails.margin',
                'cart_retails.disc',
                'cart_retails.cut_sale',
                'cart_retails.harga_up',
                'cart_retails.jumlah',
                'cart_retails.subtotal_pk',
                'cart_retails.subtotal_up',
                'item_models.gambar')
        ->get();
        $big = CartRetail::where('user_id',$user)->sum('subtotal_up');
        $big2 = CartRetail::where('user_id',$user)->sum('subtotal_pk');

        $date = new DateTime();
        $req = TransaksiRetail::select('no_nota')->orderby('created_at','desc')->first();

        if($req != null){
            $bulan = $date->format('m');
            $bulanreq = substr($req->code_master,6,2);
            if($bulan == $bulanreq){
                $pcod = substr($req->code_master,13);
                $codplus = (int)$pcod + 1;
                $codigit = sprintf("%05s",$codplus);
                $kode = 'RN'.$date->format('dmyHis');
            }else{
                $kode = 'RN'.$date->format('dmyHis');
            }
        }else{
            $kode = 'RN'.$date->format('dmyHis');
        }

        return view('retail/pos',compact('retail','cabang','cart','big','big2','user','date','req','kode'));

    }

    public function addcart(Request $request){
        $aut = Auth::user()->cabang_id;
        $user = Auth::user()->id;
        $id = $request->id;
        $idkom = $request->code_item;
        $qty = $request->jumlah;
        $hargapk =  $request->harga_pk;
        $margin  = $request->margin;
        $hargaup = $request->harga_up;
        $discount = $request->disc;
        $cutsale  = $request->cut_sale;
        $hitungs= $hargapk*$qty;
        $hitung1= $hargaup*$qty;
        $cutsales =  $qty * $cutsale;
       
        // dd($cutsale );
        

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
        $cek = CartRetail::where('code_item',$idkom)->where('user_id',$user)->count();
        $cekstok = InventoryRetail::where('code_item',$idkom)->where('cabang_id',$aut)->sum('stok');
        // dd($cekstok);
        if($cekstok < $qty){
            return redirect()->back() ->with('alert', 'Stok tidak Cukup!');
        }
        else{
            if($cek){
            
                if($discount > 0){
                    $input = CartRetail::where('code_item',$idkom)->where('user_id',$user)->update([
                        'jumlah' => DB::raw("jumlah + $qty"),'subtotal_pk' => DB::raw("(harga_pk * jumlah) - $discounts"),'disc' => $discounts,'subtotal_up' => DB::raw("(harga_up * jumlah) - $discounts")
                    ]);
                    $kurangilah = InventoryRetail::where('code_item',$idkom)->where('cabang_id',$aut)->update(['stok' => DB::raw("stok - $qty"),'subtotal_up' => DB::raw('harga_up * stok')]);

                }
                elseif($cutsale > 0){
                    $input = CartRetail::where('code_item',$idkom)->where('user_id',$user)->update([
                        'jumlah' => DB::raw("jumlah + $qty"),'subtotal_pk' => DB::raw("(harga_pk * jumlah) - $cutsales"),'subtotal_up' => DB::raw("(harga_up * jumlah) - (jumlah * $cutsale)"),'cut_sale' => DB::raw("$cutsale")
                    ]);
                    
                    $kurangilah = InventoryRetail::where('code_item',$idkom)->where('cabang_id',$aut)->update(['stok' => DB::raw("stok - $qty"),'subtotal_up' => DB::raw('harga_up * stok')]);
    
                }
                else{
                    $input = CartRetail::where('code_item',$idkom)->where('user_id',$user)->update(['jumlah' => DB::raw("jumlah + $qty"),
                        'subtotal_pk' => DB::raw("harga_pk * jumlah"),'subtotal_up' => DB::raw("harga_up * jumlah"),
                    ]);
                    
                    $kurangilah = InventoryRetail::where('code_item',$idkom)->where('cabang_id',$aut)->update(['stok' => DB::raw("stok - $qty"),'subtotal_up' => DB::raw('harga_up * stok')]);
                }
    
            }
            else{
                if($discount > 0){
                    $masukan = CartRetail::insert(['code_item'=>$idkom,'harga_pk'=>$hargapk,'margin'=> $margin,'harga_up'=>$hargaup,'jumlah'=>$qty,'disc'=>$discount,'cut_sale'=>$cutsales,'subtotal_pk'=>$subhpp,'subtotal_up'=>$subtotal,'cabang_id'=>$aut,'user_id'=>$user]);
    
                    $kurangilah = InventoryRetail::where('code_item',$idkom)->where('cabang_id',$aut)->update(['stok' => DB::raw("stok - $qty"),'subtotal_up' => DB::raw('harga_up * stok')]);
                }
                elseif($cutsale > 0){
                    $masukan = CartRetail::insert(['code_item'=>$idkom,'harga_pk'=>$hargapk,'margin'=> $margin,'harga_up'=>$hargaup,'jumlah'=>$qty,'disc'=>$discount,'cut_sale'=>$cutsales,'subtotal_pk'=>$subhpp,'subtotal_up'=>$subtotal,'cabang_id'=>$aut,'user_id'=>$user]);
                
                    $kurangilah = InventoryRetail::where('code_item',$idkom)->where('cabang_id',$aut)->update(['stok' => DB::raw("stok - $qty"),'subtotal_up' => DB::raw('harga_up * stok')]);
                }
                else{
                    $masukan = CartRetail::insert(['code_item'=>$idkom,'harga_pk'=>$hargapk,'margin'=> $margin,'harga_up'=>$hargaup,'jumlah'=>$qty,'disc'=>$discount,'cut_sale'=>$cutsales,'subtotal_pk'=>$qty*$hargapk,'subtotal_up'=>$qty*$hargaup,'cabang_id'=>$aut,'user_id'=>$user]);
                
                    $kurangilah = InventoryRetail::where('code_item',$idkom)->where('cabang_id',$aut)->update(['stok' => DB::raw("stok - $qty"),'subtotal_up' => DB::raw('harga_up * stok')]);
                }
                
            }
        }
       
       

        return back()->with('succes','Product Masuk Keranjang');
    }

    public function invoice(Request $request){
        $cabang = Auth::user()->cabang_id;
        $userid =  Auth::user()->id;
        $no_nota = $request->nota;
        $big = $request->big;
        $big2 = $request->big2;
        $bayar = $request->bayar;
        $kembali = $request->kembali;
        $cart = CartRetail::where('user_id',$userid)->get();
        $cek  = DetailRetail::where('no_nota',$no_nota)->where('user_id',$userid)->count();

        // dd($cart);
        foreach($cart as $c){
        $id = $c->id;
        $codeitem = $c->code_item;
        $jumlah = $c->jumlah;
        $hargapk = $c->harga_pk;
        $margin = $c->margin;
        $hargaup = $c->harga_up;
        $disc = $c->disc;
        $cutsale = $c->cut_sale;
        $subtotalpk = $c->subtotal_pk;
        $subtotalup = $c->subtotal_up;
        $cabang = $c->cabang_id;
        $user = $c->user_id;  
        // dd($c->code_item);
        
        if($cek){

        }
        else{
            $input = new DetailRetail();
            $input->no_nota = $no_nota ;
            $input->cabang_id = $cabang ;
            $input->user_id = $userid;
            $input->code_item = $codeitem;
            $input->harga_pk = $hargapk;
            $input->margin = $margin;
            $input->harga_up = $hargaup;
            $input->jumlah = $jumlah;
            $input->disc = $disc;
            $input->cut_sale = $cutsale;
            $input->subtotal_pk = $subtotalpk;
            $input->subtotal_up = $subtotalup;
            $input->tanggal_transaksi = date('Y-m-d');
            $input->save();
            
            // $pengurangan = InventoryRetail::where('code_item',$codeitem)->get();
            // dd($pengurangan);
        }
    }
        $cek2 = TransaksiRetail::where('user_id',$userid)->where('cabang_id',$cabang)->where('no_nota',$no_nota)->count();
        if($cek2){

        }
        else{
            $sum = DetailRetail::where('user_id',$userid)->where('cabang_id',$cabang)->where('no_nota',$no_nota)->sum('subtotal_pk');
            $sum2 = DetailRetail::where('user_id',$userid)->where('cabang_id',$cabang)->where('no_nota',$no_nota)->sum('subtotal_up');
            $input = new TransaksiRetail();
            $input->cabang_id = $cabang;
            $input->user_id = Auth::user()->id;
            $input->no_nota = $no_nota;
            $input->tanggal_transaksi = date('Y-m-d');
            $input->subtotal_pk = $big2;
            $input->subtotal_up = $big;
            $input->bayar = $bayar;
            $input->kembali = $bayar-$big;
            $input->save(); 
        }

    
        $nota = TransaksiRetail::where('user_id',$userid)->where('no_nota',$no_nota)
        ->select('transaksi_retails.no_nota',
        'transaksi_retails.tanggal_transaksi',
        'transaksi_retails.subtotal_pk',
        'transaksi_retails.subtotal_up',
        'transaksi_retails.bayar',
        'transaksi_retails.kembali')
        ->get();

        $detail = DetailRetail::where('user_id',$userid)->where('no_nota',$no_nota)
        ->join('item_models','detail_retails.code_item','item_models.code_item')
        ->select('detail_retails.no_nota',
        'detail_retails.cabang_id',
        'detail_retails.user_id',
        'item_models.nama_item',
        'detail_retails.harga_pk',
        'detail_retails.margin',
        'detail_retails.harga_up',
        'detail_retails.jumlah',
        'detail_retails.disc',
        'detail_retails.cut_sale',
        'detail_retails.subtotal_pk',
        'detail_retails.subtotal_up',
        'detail_retails.tanggal_transaksi')
        ->get();
        // dd($detail);
        $sumbig = DetailRetail::where('user_id',$userid)->where('no_nota',$no_nota)->sum('subtotal_up');
        $hapus = CartRetail::where('user_id',$userid)->delete();
        $namacabang = CabangModel::where('id',$cabang)->select('nama_cabang','no_hp')->get();
        
        return view('retail/print',compact('nota','detail','sumbig','namacabang','no_nota'));

    }
    public function notapos(){
        $cabang = Auth::user()->cabang_id;
        $now = date('Y-m-d');
        $nota = TransaksiRetail::join('users','transaksi_retails.user_id','users.id')->join('cabang','transaksi_retails.cabang_id','cabang.id')
        ->where('transaksi_retails.tanggal_transaksi',$now)
        ->where('transaksi_retails.cabang_id',$cabang)
        ->select('transaksi_retails.id',
                'transaksi_retails.no_nota',
                'transaksi_retails.tanggal_transaksi',
                'transaksi_retails.subtotal_pk',
                'transaksi_retails.subtotal_up',
                'transaksi_retails.bayar',
                'transaksi_retails.kembali',
                'cabang.nama_cabang',
                'users.name')
                ->get();
                $pk = TransaksiRetail::where('cabang_id',$cabang)->where('tanggal_transaksi',$now)->sum('subtotal_pk');
                $up = TransaksiRetail::where('cabang_id',$cabang)->where('tanggal_transaksi',$now)->sum('subtotal_up');
                return view('retail/datapos',compact('cabang','nota','pk','up','now'));
    }
    
    public function filternotapos(Request $request){
        $cabang = Auth::user()->cabang_id;
        $cek = $request->datetimes;
        $string = explode('-',$cek);

        $date1 = explode('/',$string[0]);
        $date2 = explode('/',$string[1]);

        $finalDate1 = $date1[0].'-'.$date1[1].'-'.$date1[2];
        $finalDate2 = $date2[0].'-'.$date2[1].'-'.$date2[2];
        $nota = TransaksiRetail::join('users','transaksi_retails.user_id','users.id')->join('cabang','transaksi_retails.cabang_id','cabang.id')
        ->whereBetween('transaksi_retails.tanggal_transaksi',[$finalDate1, $finalDate2])
        ->where('transaksi_retails.cabang_id',$cabang)
        ->select('transaksi_retails.id',
                'transaksi_retails.no_nota',
                'transaksi_retails.tanggal_transaksi',
                'transaksi_retails.subtotal_pk',
                'transaksi_retails.subtotal_up',
                'transaksi_retails.bayar',
                'transaksi_retails.kembali',
                'cabang.nama_cabang',
                'users.name')
                ->get();
                $pk = TransaksiRetail::where('cabang_id',$cabang)->whereBetween('tanggal_transaksi',[$finalDate1, $finalDate2])->sum('subtotal_pk');
                $up = TransaksiRetail::where('cabang_id',$cabang)->whereBetween('tanggal_transaksi',[$finalDate1, $finalDate2])->sum('subtotal_up');
                return view('retail/filterdatapos',compact('cabang','nota','pk','up','cek','finalDate1','finalDate2','string','date1','date2'));
    }
    public function detailnota(Request $request){
        $cabang = Auth::user()->cabang_id;
        $no_nota = $request->no_nota;
        $detail = DetailRetail::where('detail_retails.cabang_id',$cabang)->where('no_nota',$no_nota)
        ->join('item_models','detail_retails.code_item','item_models.code_item')
        ->select('detail_retails.no_nota',
        'detail_retails.cabang_id',
        'detail_retails.user_id',
        'item_models.nama_item',
        'detail_retails.harga_pk',
        'detail_retails.margin',
        'detail_retails.harga_up',
        'detail_retails.jumlah',
        'detail_retails.disc',
        'detail_retails.cut_sale',
        'detail_retails.subtotal_pk',
        'detail_retails.subtotal_up',
        'detail_retails.tanggal_transaksi')
        ->get();
        $modal = DetailRetail::where('cabang_id',$cabang)->where('no_nota',$no_nota)->sum('subtotal_pk');
        
        $profit = DetailRetail::where('cabang_id',$cabang)->where('no_nota',$no_nota)->sum('subtotal_up');
        // dd($profit);
        return view('retail/detailnota',compact('cabang','no_nota','detail','modal','profit'));
    }
    //  public function datapenjualan(){
    //     $cabang = Auth::user()->cabang_id;
    //     $now = date('Y-m-d');
    //     $detail = DetailRetail::where('detail_retails.cabang_id',$cabang)
    //     ->where('detail_retails.tanggal_transaksi',$now)
    //     ->join('item_models','detail_retails.code_item','item_models.code_item')
    //     ->select('detail_retails.no_nota',
    //     'detail_retails.code_item',
    //     'detail_retails.cabang_id',
    //     'detail_retails.user_id',
    //     'item_models.nama_item',
    //     'detail_retails.harga_pk',
    //     'detail_retails.margin',
    //     'detail_retails.harga_up',
    //     'detail_retails.jumlah',
    //     'detail_retails.disc',
    //     'detail_retails.cut_sale',
    //     'detail_retails.subtotal_pk',
    //     'detail_retails.subtotal_up',
    //     'detail_retails.tanggal_transaksi')
    //     ->orderBy('item_models.nama_item','asc')
    //     ->get();
    //     $modal = DetailRetail::where('cabang_id',$cabang)->where('tanggal_transaksi',$now)->sum('subtotal_pk');
        
    //     $profit = DetailRetail::where('cabang_id',$cabang)->where('tanggal_transaksi',$now)->sum('subtotal_up');

    //     return view('retail/datapenjualan',compact('cabang','detail','modal','profit','now'));
    // }
    
    public function datapenjualan(){
        $cabang = Auth::user()->cabang_id;
        $kategori = DB::table('kategori_item')->get();
        $now = date('Y-m-d');
        $detail = DetailRetail::where('detail_retails.cabang_id',$cabang)
        
        ->where('detail_retails.tanggal_transaksi',$now)
        ->join('item_models','detail_retails.code_item','item_models.code_item')
        
        // ->groupBy('detail_retails.code_item,item_models.nama_item')
        // ->selectRaw('sum(detail_retails.jumlah) as sum,
        // item_models.nama_item,item_models.code_item')
        // ->select('detail_retails.no_nota',
        // 'detail_retails.code_item',
        // 'detail_retails.cabang_id',
        // 'detail_retails.user_id',
        // 'item_models.nama_item',
        // 'detail_retails.harga_pk',
        // 'detail_retails.margin',
        // 'detail_retails.harga_up',
        // 'detail_retails.jumlah',
        // 'detail_retails.disc',
        // 'detail_retails.cut_sale',
        // 'detail_retails.subtotal_pk',
        // 'detail_retails.subtotal_up',
        // 'detail_retails.tanggal_transaksi')
        // ->orderBy('item_models.nama_item','asc')
        // ->get();
        ->select("detail_retails.code_item","item_models.nama_item","detail_retails.harga_up",
                DB::raw("(sum(detail_retails.jumlah)) as sum"),DB::raw("(sum(detail_retails.subtotal_up)) as tot"))
                            ->orderBy('item_models.nama_item','asc')
                            ->groupBy(DB::raw("detail_retails.code_item,item_models.nama_item,detail_retails.harga_up"))
                            ->get();
        
        // dd($detail);
        // $modal = DetailRetail::where('cabang_id',$cabang)->where('tanggal_transaksi',$now)->sum('subtotal_pk');
        
        $profit = DetailRetail::where('cabang_id',$cabang)->where('tanggal_transaksi',$now)->sum('subtotal_up');

        return view('retail/datapenjualan',compact('cabang','detail','profit','now','kategori'));
    }
    
    public function filterdatapenjualan(Request $request){
        $cabang = Auth::user()->cabang_id;
        $kategori = DB::table('kategori_item')->get();
        $kat = $request->id_kategori;
        // dd($kat);
        $cek = $request->datetimes;
        $string = explode('-',$cek);

        $date1 = explode('/',$string[0]);
        $date2 = explode('/',$string[1]);

        $finalDate1 = $date1[0].'-'.$date1[1].'-'.$date1[2];
        $finalDate2 = $date2[0].'-'.$date2[1].'-'.$date2[2];
       $detail = DetailRetail::where('detail_retails.cabang_id',$cabang)
        
        ->whereBetween('detail_retails.tanggal_transaksi',[$finalDate1, $finalDate2])
        ->join('item_models','detail_retails.code_item','item_models.code_item')
        ->where('item_models.id_kategori',$kat)
        // ->groupBy('detail_retails.code_item,item_models.nama_item')
        // ->selectRaw('sum(detail_retails.jumlah) as sum,
        // item_models.nama_item,item_models.code_item')
        // ->select('detail_retails.no_nota',
        // 'detail_retails.code_item',
        // 'detail_retails.cabang_id',
        // 'detail_retails.user_id',
        // 'item_models.nama_item',
        // 'detail_retails.harga_pk',
        // 'detail_retails.margin',
        // 'detail_retails.harga_up',
        // 'detail_retails.jumlah',
        // 'detail_retails.disc',
        // 'detail_retails.cut_sale',
        // 'detail_retails.subtotal_pk',
        // 'detail_retails.subtotal_up',
        // 'detail_retails.tanggal_transaksi')
        // ->orderBy('item_models.nama_item','asc')
        // ->get();
        ->select("detail_retails.code_item","item_models.nama_item","detail_retails.harga_up",
                DB::raw("(sum(detail_retails.jumlah)) as sum"),DB::raw("(sum(detail_retails.subtotal_up)) as tot"))
                            ->orderBy('item_models.nama_item','asc')
                            ->groupBy(DB::raw("detail_retails.code_item,item_models.nama_item,detail_retails.harga_up"))
                            ->get();
        
        // dd($detail);
        // $modal = DetailRetail::where('cabang_id',$cabang)->where('tanggal_transaksi',$now)->sum('subtotal_pk');
        
        $profit = DetailRetail::join('item_models','detail_retails.code_item','item_models.code_item')
        ->where('item_models.id_kategori',$kat)->where('detail_retails.cabang_id',$cabang)->whereBetween('detail_retails.tanggal_transaksi',[$finalDate1, $finalDate2])->sum('detail_retails.subtotal_up');

        return view('retail/datapenjualan',compact('cabang','detail','profit','cek','finalDate1','finalDate2','string','date1','date2','kategori'));
                // return view('retail/filterdatapos',compact('cabang','nota','pk','up','cek','finalDate1','finalDate2','string','date1','date2'));
    }
    
     public function penjualanitem(){
        $cabang = Auth::user()->cabang_id;
        $now = date('Y-m-d');
        $detail = DetailRetail::where('detail_retails.cabang_id',$cabang)
        ->where('detail_retails.tanggal_transaksi',$now)
        ->join('item_models','detail_retails.code_item','item_models.code_item')
        ->select('detail_retails.id',
        'detail_retails.no_nota',
        'detail_retails.code_item',
        'detail_retails.cut_sale',
        'detail_retails.disc',
        'item_models.nama_item',
        'detail_retails.harga_up',
        'detail_retails.jumlah as total',
        'detail_retails.subtotal_up',
        'detail_retails.tanggal_transaksi')
        ->orderBy('detail_retails.tanggal_transaksi','asc')
        ->orderBy('item_models.nama_item','asc')
        ->get();
        $total = DetailRetail::where('cabang_id',$cabang)
        ->where('tanggal_transaksi',$now)
        ->sum('subtotal_up');
        // dd($detail);
        return view('retail/penjualanitem',compact('cabang','detail','total','now'));
    }
    
    public function filterpenjualanitem(Request $request){
        $cabang = Auth::user()->cabang_id;
        $cek = $request->datetimes;
        $string = explode('-',$cek);

        $date1 = explode('/',$string[0]);
        $date2 = explode('/',$string[1]);

        $finalDate1 = $date1[0].'-'.$date1[1].'-'.$date1[2];
        $finalDate2 = $date2[0].'-'.$date2[1].'-'.$date2[2];
        $detail = DetailRetail::where('detail_retails.cabang_id',$cabang)
        ->whereBetween('detail_retails.tanggal_transaksi',[$finalDate1, $finalDate2])
        ->join('item_models','detail_retails.code_item','item_models.code_item')
        ->select('detail_retails.id',
        'detail_retails.no_nota',
        'detail_retails.code_item',
        'item_models.nama_item',
         'detail_retails.cut_sale',
        'detail_retails.disc',
        'detail_retails.harga_up',
        'detail_retails.jumlah as total',
        'detail_retails.subtotal_up',
        'detail_retails.tanggal_transaksi')
        ->orderBy('detail_retails.tanggal_transaksi','asc')
        // ->orderBy('item_models.nama_item','asc')
        ->get();
        $total = DetailRetail::where('cabang_id',$cabang)
        ->whereBetween('tanggal_transaksi',[$finalDate1, $finalDate2])
        ->sum('subtotal_up');
        // dd($detail);
        return view('retail/penjualanitem',compact('cabang','detail','total','cek','finalDate1','finalDate2','string','date1','date2'));
    }
    
    public function deleteretail(Request $request){
        $cabang = Auth::user()->cabang_id;
        $id = $request->id;
        $code_item = $request->code_item;
        $jumlah = $request->jumlah;
        // dd($code_item);
        $kembali = InventoryRetail::where('code_item',$code_item)->where('cabang_id',$cabang)->update(['stok' => DB::raw("stok + $jumlah")]);

        $delete  = CartRetail::where('id',$id)->delete();
       
       
        return back()->with('succes','Product Masuk Keranjang');
    }

    public function restokretail(Request $request){
        $cabang = Auth::user()->cabang_id;
        $tgl = date('Y-m-d');
        $codeitem = $request->code_item;
        $stok     = $request->jumlah;
        $id       = $request->id;
        $hargapk  = $request->hargapk;
        $hargaup  = $request->hargaup;
        $stoks    = $request->stok;
        $restok = InventoryRetail::where('code_item',$codeitem)->where('cabang_id',$cabang)->update(['stok' =>DB::raw("stok + $stok"),'subtotal_pk' => DB::raw('stok * harga_pk'),'subtotal_up' =>DB::raw('stok * harga_up')]);
        $histori_invent = DB::table('histori_inventories')
        ->insert(['id_item' => $id,
        'hargapk' =>$hargapk,
        'hargaup' => $hargaup,
        'jumlah' => $stoks,
        'subtotalpk' => ($hargapk * $stoks),
        'subtotalup' => ($hargaup * $stoks),
        'cabang_id' => $cabang,
        'tgl_histori' => $tgl]);
        $histori_stok = DB::table('histori_restok')
        ->insert(['id_item' => $id,
        'hargapk' =>$hargapk,
        'hargaup' => $hargaup,
        'jumlah' => $stok,
        'subtotalpk' =>($hargapk * $stok),
        'subtotalup' =>($hargaup * $stok),
        'cabang_id' => $cabang,
        'tgl_restok' => $tgl]);
        return back()->with('succes','Product di Restok');
    }
    
    public function filterhistoryinven(Request $request){
        $cabang = Auth::user()->cabang_id;
        $cek = $request->datetimes;
        $string = explode('-',$cek);

        $date1 = explode('/',$string[0]);
        $date2 = explode('/',$string[1]);

        $finalDate1 = $date1[0].'-'.$date1[1].'-'.$date1[2];
        $finalDate2 = $date2[0].'-'.$date2[1].'-'.$date2[2];
        $data = DB::table('histori_inventories')
        ->join('item_models','histori_inventories.id_item','item_models.id')
        ->select('histori_inventories.id',
                'item_models.nama_item',
                'histori_inventories.hargapk',
                'histori_inventories.hargaup',
                'histori_inventories.jumlah',
                'histori_inventories.subtotalpk',
                'histori_inventories.subtotalup',
                'histori_inventories.tgl_histori')
        ->where('histori_inventories.cabang_id',$cabang)
        ->where('histori_inventories.tgl_histori',[$finalDate1, $finalDate2])
        ->get();
        // DD($data);
        
        return view('retail/historyinven',compact('cabang','data','cek','finalDate1','finalDate2','string','date1','date2'));
        
    }
     public function historyinven(Request $request){
        $cabang = Auth::user()->cabang_id;
        $tgl = date('Y-m-d');
        $data = DB::table('histori_inventories')
        ->join('item_models','histori_inventories.id_item','item_models.id')
        ->select('histori_inventories.id',
                'item_models.nama_item',
                'histori_inventories.hargapk',
                'histori_inventories.hargaup',
                'histori_inventories.jumlah',
                'histori_inventories.subtotalpk',
                'histori_inventories.subtotalup',
                'histori_inventories.tgl_histori')
        ->where('histori_inventories.cabang_id',$cabang)
        ->where('histori_inventories.tgl_histori',$tgl)
        ->get();
        // DD($data);
        
        return view('retail/historyinven',compact('cabang','data','tgl'));
        
    }


    public function filterhistoristok(Request $request){
        $cabang = Auth::user()->cabang_id;
        $cek = $request->datetimes;
        $string = explode('-',$cek);

        $date1 = explode('/',$string[0]);
        $date2 = explode('/',$string[1]);

        $finalDate1 = $date1[0].'-'.$date1[1].'-'.$date1[2];
        $finalDate2 = $date2[0].'-'.$date2[1].'-'.$date2[2];
        $data = DB::table('histori_restok')
        ->join('item_models','histori_restok.id_item','item_models.id')
        ->select('histori_restok.id',
                'item_models.nama_item',
                'histori_restok.hargapk',
                'histori_restok.hargaup',
                'histori_restok.jumlah',
                'histori_restok.subtotalpk',
                'histori_restok.subtotalup',
                'histori_restok.tgl_restok')
        ->where('histori_restok.cabang_id',$cabang)
        ->where('histori_restok.tgl_restok',[$finalDate1, $finalDate2])
        ->get();
        // DD($data);
        
        return view('retail/historistok',compact('cabang','data','cek','finalDate1','finalDate2','string','date1','date2'));
        
    }
     public function historistok(Request $request){
        $cabang = Auth::user()->cabang_id;
        $tgl = date('Y-m-d');
        $data = DB::table('histori_restok')
        ->join('item_models','histori_restok.id_item','item_models.id')
        ->select('histori_restok.id',
                'item_models.nama_item',
                'histori_restok.hargapk',
                'histori_restok.hargaup',
                'histori_restok.jumlah',
                'histori_restok.subtotalpk',
                'histori_restok.subtotalup',
                'histori_restok.tgl_restok')
        ->where('histori_restok.cabang_id',$cabang)
        ->where('histori_restok.tgl_restok',$tgl)
        ->get();
        // DD($data);
        
        return view('retail/historistok',compact('cabang','data','tgl'));
        
    }
    public function returnretail(Request $request){
        $cabang = Auth::user()->cabang_id;
        $user = Auth::user()->id;
        $tgl = date('Y-m-d');
        $codeitem = $request->code_item;
        $iditem   = $request->id_item;
        $margin   = $request->margin;
        $harga_pk = $request->harga_pk;
        $harga_up = $request->harga_up;
        $qty     = $request->jumlah;
        $return = ReturnRetail::insert(['code_item'=> $codeitem,
        'id_item' => $iditem,
        'harga_pk'=>$harga_pk,
        'margin' => $margin,
        'harga_up' => $harga_up,
        'qty' => $qty,
        'subtotal_pk' => DB::raw('qty * harga_pk'),
        'subtotal_up' =>DB::raw('qty * harga_up'),
        'cabang_id' => $cabang,
        'user_id' => $user,
        'tanggal_return' => $tgl]);
        $kurang = InventoryRetail::where('code_item',$codeitem)->where('cabang_id',$cabang)->update(['stok' =>DB::raw("stok - $qty"),'subtotal_pk' => DB::raw('stok * harga_pk'),'subtotal_up' =>DB::raw('stok * harga_up')]);
        return back()->with('succes','Product di Restok');
    }
    
    public function bonusretail(Request $request){
        $cabang = Auth::user()->cabang_id;
        $user = Auth::user()->id;
        $tgl = date('Y-m-d');
        $codeitem = $request->code_item;
        $iditem   = $request->id_item;
        $margin   = $request->margin;
        $harga_pk = $request->harga_pk;
        $harga_up = $request->harga_up;
        $qty     = $request->jumlah;
        $return = BonusRetail::insert(['code_item'=> $codeitem,
        'id_item' => $iditem,
        'harga_pk'=>$harga_pk,
        'margin' => $margin,
        'harga_up' => $harga_up,
        'qty' => $qty,
        'subtotal_pk' => DB::raw('qty * harga_pk'),
        'subtotal_up' =>DB::raw('qty * harga_up'),
        'cabang_id' => $cabang,
        'user_id' => $user,
        'tanggal_keluar' => $tgl]);
        $kurang = InventoryRetail::where('code_item',$codeitem)->where('cabang_id',$cabang)->update(['stok' =>DB::raw("stok - $qty"),'subtotal_pk' => DB::raw('stok * harga_pk'),'subtotal_up' =>DB::raw('stok * harga_up')]);
        return back()->with('succes','Product di Restok');
    }

    public function datareturn(Request $request){
        $cabang = Auth::user()->cabang_id;
        $user = Auth::user()->id;
        $now = date('Y-m-d');
        $retail = ReturnRetail::join('item_models','return_retails.code_item','item_models.code_item')
        ->where('return_retails.tanggal_return',$now)
        ->where('return_retails.cabang_id',$cabang)
        ->select('return_retails.id',
                'return_retails.code_item',
                'item_models.nama_item',
                'return_retails.harga_pk',
                'return_retails.margin',
                'return_retails.harga_up',
                'return_retails.qty',
                'return_retails.subtotal_pk',
                'return_retails.subtotal_up',
                'item_models.gambar',
                'return_retails.tanggal_return')
        ->orderBy('return_retails.tanggal_return','desc')
        ->get();
        $sumqty = ReturnRetail::where('cabang_id',$cabang)->where('tanggal_return',$now)->sum('qty');
        $sumj = ReturnRetail::where('cabang_id',$cabang)->where('tanggal_return',$now)->sum('subtotal_pk');
        $sumt = ReturnRetail::where('cabang_id',$cabang)->where('tanggal_return',$now)->sum('subtotal_up');
        return view('retail/datareturn',compact('cabang','user','retail','sumqty','sumj','sumt','now'));
    }
    
    public function filterdatareturn(Request $request){
        $cabang = Auth::user()->cabang_id;
        $user = Auth::user()->id;
        $cek = $request->datetimes;
        $string = explode('-',$cek);

        $date1 = explode('/',$string[0]);
        $date2 = explode('/',$string[1]);

        $finalDate1 = $date1[0].'-'.$date1[1].'-'.$date1[2];
        $finalDate2 = $date2[0].'-'.$date2[1].'-'.$date2[2];
        $retail = ReturnRetail::join('item_models','return_retails.code_item','item_models.code_item')
        ->whereBetween('return_retails.tanggal_return',[$finalDate1, $finalDate2])
        ->where('return_retails.cabang_id',$cabang)
        ->select('return_retails.id',
                'return_retails.code_item',
                'item_models.nama_item',
                'return_retails.harga_pk',
                'return_retails.margin',
                'return_retails.harga_up',
                'return_retails.qty',
                'return_retails.subtotal_pk',
                'return_retails.subtotal_up',
                'item_models.gambar',
                'return_retails.tanggal_return')
        ->orderBy('return_retails.tanggal_return','desc')
        ->get();
        $sumqty = ReturnRetail::where('cabang_id',$cabang)->whereBetween('tanggal_return',[$finalDate1, $finalDate2])->sum('qty');
        $sumj = ReturnRetail::where('cabang_id',$cabang)->whereBetween('tanggal_return',[$finalDate1, $finalDate2])->sum('subtotal_pk');
        $sumt = ReturnRetail::where('cabang_id',$cabang)->whereBetween('tanggal_return',[$finalDate1, $finalDate2])->sum('subtotal_up');
        return view('retail/filterdatareturn',compact('cabang','user','retail','sumqty','sumj','sumt'));
    }
    
    public function filterdatabonus(Request $request){
        $cabang = Auth::user()->cabang_id;
        $user = Auth::user()->id;
        $cek = $request->datetimes;
        $string = explode('-',$cek);

        $date1 = explode('/',$string[0]);
        $date2 = explode('/',$string[1]);

        $finalDate1 = $date1[0].'-'.$date1[1].'-'.$date1[2];
        $finalDate2 = $date2[0].'-'.$date2[1].'-'.$date2[2];
        $retail = BonusRetail::join('item_models','bonus_retails.code_item','item_models.code_item')
        ->whereBetween('bonus_retails.tanggal_keluar',[$finalDate1, $finalDate2])
        ->where('bonus_retails.cabang_id',$cabang)
        ->select('bonus_retails.id',
                'bonus_retails.code_item',
                'item_models.nama_item',
                'bonus_retails.harga_pk',
                'bonus_retails.margin',
                'bonus_retails.harga_up',
                'bonus_retails.qty',
                'bonus_retails.subtotal_pk',
                'bonus_retails.subtotal_up',
                'item_models.gambar',
                'bonus_retails.tanggal_keluar')
        ->orderBy('bonus_retails.tanggal_keluar','desc')
        ->get();
        $sumqty = BonusRetail::where('cabang_id',$cabang)->whereBetween('tanggal_keluar',[$finalDate1, $finalDate2])->sum('qty');
        $sumj = BonusRetail::where('cabang_id',$cabang)->whereBetween('tanggal_keluar',[$finalDate1, $finalDate2])->sum('subtotal_pk');
        $sumt = BonusRetail::where('cabang_id',$cabang)->whereBetween('tanggal_keluar',[$finalDate1, $finalDate2])->sum('subtotal_up');
        return view('retail/filterdatabonus',compact('cabang','user','retail','sumqty','sumj','sumt'));
    }
    
     public function databonus(Request $request){
        $cabang = Auth::user()->cabang_id;
        $user = Auth::user()->id;
         $now = date('Y-m-d');
        $retail = BonusRetail::join('item_models','bonus_retails.code_item','item_models.code_item')
        ->where('bonus_retails.cabang_id',$cabang)
        ->where('bonus_retails.tanggal_keluar',$now)
        ->select('bonus_retails.id',
                'bonus_retails.code_item',
                'item_models.nama_item',
                'bonus_retails.harga_pk',
                'bonus_retails.margin',
                'bonus_retails.harga_up',
                'bonus_retails.qty',
                'bonus_retails.subtotal_pk',
                'bonus_retails.subtotal_up',
                'item_models.gambar',
                'bonus_retails.tanggal_keluar')
        ->orderBy('bonus_retails.tanggal_keluar','desc')
        ->get();
        $sumqty = BonusRetail::where('cabang_id',$cabang)->where('tanggal_keluar',$now)->sum('qty');
        $sumj = BonusRetail::where('cabang_id',$cabang)->where('tanggal_keluar',$now)->sum('subtotal_pk');
        $sumt = BonusRetail::where('cabang_id',$cabang)->where('tanggal_keluar',$now)->sum('subtotal_up');
        return view('retail/databonus',compact('cabang','user','retail','sumqty','sumj','sumt','now'));
    }
    
    
    public function editretail(Request $request){
        $cabang = Auth::user()->cabang_id;
        $id = $request->id;
        $code_item = $request->code_item;
        $qty  = $request->jumlah;
        $cekstok = InventoryRetail::where('code_item',$code_item)->where('cabang_id',$cabang)->sum('stok');
        
        $cekcart = CartRetail::where('code_item',$code_item)->sum('jumlah');
        // dd($cekcart);
        if($cekstok < 1){
            return redirect()->back() ->with('alert', 'Stok tidak Cukup!');
        }
        else{
            if($cekcart > $qty){
                 $kurangilah = InventoryRetail::where('code_item',$code_item)->update(['stok' => DB::raw("stok + ($cekcart - $qty)")]);
            }
            elseif($cekcart < $qty){
                $kurangilah = InventoryRetail::where('code_item',$code_item)->update(['stok' => DB::raw("stok - ($qty - $cekcart)")]);
            }
            else{
                
            }
            $cart = CartRetail::where('id',$id)->update(['jumlah'=> $qty,'subtotal_pk' => DB::raw("harga_pk * $qty"),'subtotal_up' => DB::raw("harga_up * $qty")]);
           

        }
       
        return back()->with('succes','Product Masuk Keranjang');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cabang = Auth::user()->cabang_id;
        $item = ItemModel::where('cabang_id',$cabang)->orderby('nama_item','asc')->get();
        // dd($item);

        return view('retail/create',compact('item','cabang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cabang         = Auth::user()->cabang_id;
        $user           = Auth::user()->id;
        

        foreach($request->code_item as $key => $value)
        {
            $qty = $request->stok[$key];
            $cek = InventoryRetail::where('code_item',$value)->count();
            if($cek){
                $update = InventoryRetail::where('code_item',$value)->update(['stok' => DB::raw("stok + $qty"),'subtotal_pk' => DB::raw('harga_pk * stok'),'subtotal_up' => DB::raw('harga_up * stok')]);
            }
            else{
            $input = new InventoryRetail(); 
            $input->cabang_id = $cabang; 
            $input->user_id = $user; 
            $input->code_item = $value;
            $input->stok      = $request->stok[$key];
            $item = ItemModel::where('code_item',$value)->get();
            // dd($item);
            foreach($item as $items){
                $id = $items->id;
                $harga_jual = $items->harga_jual;
                $harga_pokok = $items->hpp;
                // dd($harga_pokok);
                $input->id_item = $id;
                $input->harga_pk = $harga_pokok;
                $input->margin = $harga_jual - $harga_pokok;
                $input->harga_up = $harga_jual;
                $input->subtotal_pk = $harga_pokok * $request->stok[$key];
                $input->subtotal_up = $harga_jual * $request->stok[$key];
                $input->save();

            }
           
            }
        }
       
        return back()->with('success', 'Record Created Successfully.');
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
