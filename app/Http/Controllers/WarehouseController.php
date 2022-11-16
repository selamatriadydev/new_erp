<?php

namespace App\Http\Controllers;
use App\Master;
use App\MasterPremix;
use DateTime;
use App\CabangModel;
use App\PotonganHarga;
use App\SatuanModel;
use App\ElementPremix;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cabang_id = Auth::user()->cabang_id;
        $kategori = DB::table('kategori_bahan')->select('id','kategori')->get();
        $master = Master::join('satuan_models','masters.id_satuan','satuan_models.id')
        // ->where('id_cabang',$cabang_id)
        // ->where('masters.id_kategori','=',"6")
        ->select('masters.id',
                'masters.code_master',
                'masters.nama_barang',
                'masters.berat',
                'satuan_models.nama_satuan',
                'masters.harga_pokok',
                'masters.margin',
                'masters.harga_jual',
                'masters.stok',
                'masters.sub_total_pokok',
                'masters.sub_total_jual',
                'masters.id_cabang')
                ->orderBy('masters.id','desc')
                ->get();
                
                // dd($master);
        // $master = Master::join('satuan_models','masters.id_satuan','satuan_models.id')
        //                 ->where('id_cabang',$cabang_id)
        //                 // ->where('berat','>','99')
        //                 ->select(
        //                         'masters.id',
        //                         'masters.code_master as code_masters',
        //                         'masters.nama_barang as barangs',
        //                         'satuan_models.nama_satuan',
        //                         // DB::raw('MIN(satuan_models.nama_satuan) as satuans'),
        //                         //  DB::raw('GROUP_CONCAT(masters.nama_barang) as barangs'),
        //                          DB::raw('MAX(masters.berat) as berats'),
        //                          DB::raw('MAX(masters.stok) as stoks'),
        //                          DB::raw('GROUP_CONCAT(satuan_models.nama_satuan) as satuans'),
        //                          DB::raw('MIN(masters.harga_jual) as harga')
                                 
        //                         // 'masters.nama_barang',
        //                         // 'masters.berat',
        //                         // 'satuan_models.nama_satuan',
        //                         // 'masters.harga_pokok',
        //                         // 'masters.margin',
        //                         // 'masters.harga_jual',
        //                         // 'masters.stok',
        //                         // 'masters.sub_total_pokok',
        //                         // 'masters.sub_total_jual',
        //                         )
        //                 ->orderBy('masters.id','desc')
        //                 ->groupBy('satuan_models.nama_satuan','masters.id','masters.code_master','masters.nama_barang')
        //                 ->get();
        // dd($master);        
        return view('warehouse/indexmaster',compact('cabang_id','master','kategori'));
    }


    public function form_potongan(){
        $master = Master::join('satuan_models','masters.id_satuan','satuan_models.id')
        // ->where('id_cabang',$cabang_id)
        // ->where('masters.id_kategori','=',"6")
        ->select('masters.id',
                'masters.code_master',
                'masters.nama_barang',
                'masters.berat',
                'satuan_models.nama_satuan',
                'masters.harga_pokok',
                'masters.margin',
                'masters.harga_jual',
                'masters.stok',
                'masters.sub_total_pokok',
                'masters.sub_total_jual',
                'masters.id_cabang')
                ->orderBy('masters.id','desc')
                ->get();
        
        
        return view('warehouse.potonganinput',compact('master'));
    }
    public function potongan(){
        $potongan = PotonganHarga::join('masters','potongan_hargas.id_produk','masters.id')
                                    ->join('satuan_models','masters.id_satuan','satuan_models.id')
                                    ->select('masters.id','satuan_models.nama_satuan','masters.code_master','masters.nama_barang','potongan_hargas.range1','potongan_hargas.range2','potongan_hargas.potongan')
                                    ->get();
        
        return view('warehouse/potongan',compact('potongan'));

    }

    public function input_potongan(Request $request){
        $id_produk = $request->id_produk;
  
        $request->validate([
            'addmore.*.range1',
            'addmore.*.range2',
            'addmore.*.potongan',
            
        ]);
    
        foreach ($request->addmore as $key => $value) {
                $insert = PotonganHarga::create([
                    'id_produk' => $id_produk,
                    'range1'     => $value['range1'],
                    'range2' => $value['range2'],
                    'potongan'  => $value['potongan'],
                ]);
            }
        
        
        return back()->with('success', 'Record Created Successfully.');

    }

    public function filterkategori(Request $request)
    {
        $idkat = $request->filter_id;
        $cabang_id = Auth::user()->cabang_id;
        $kategori = DB::table('kategori_bahan')->select('id','kategori')->get();
        $master = Master::join('satuan_models','masters.id_satuan','satuan_models.id')
        ->where('id_cabang',$cabang_id)
        ->where('masters.id_kategori',$idkat)
        ->select('masters.id',
                'masters.code_master',
                'masters.nama_barang',
                'masters.berat',
                'satuan_models.nama_satuan',
                'masters.harga_pokok',
                'masters.margin',
                'masters.harga_jual',
                'masters.stok',
                'masters.sub_total_pokok',
                'masters.sub_total_jual',
                'masters.id_cabang')
                ->orderBy('masters.id','desc')
                ->get();
                
                // dd($master);
        // $master = Master::join('satuan_models','masters.id_satuan','satuan_models.id')
        //                 ->where('id_cabang',$cabang_id)
        //                 // ->where('berat','>','99')
        //                 ->select(
        //                         'masters.id',
        //                         'masters.code_master as code_masters',
        //                         'masters.nama_barang as barangs',
        //                         'satuan_models.nama_satuan',
        //                         // DB::raw('MIN(satuan_models.nama_satuan) as satuans'),
        //                         //  DB::raw('GROUP_CONCAT(masters.nama_barang) as barangs'),
        //                          DB::raw('MAX(masters.berat) as berats'),
        //                          DB::raw('MAX(masters.stok) as stoks'),
        //                          DB::raw('GROUP_CONCAT(satuan_models.nama_satuan) as satuans'),
        //                          DB::raw('MIN(masters.harga_jual) as harga')
                                 
        //                         // 'masters.nama_barang',
        //                         // 'masters.berat',
        //                         // 'satuan_models.nama_satuan',
        //                         // 'masters.harga_pokok',
        //                         // 'masters.margin',
        //                         // 'masters.harga_jual',
        //                         // 'masters.stok',
        //                         // 'masters.sub_total_pokok',
        //                         // 'masters.sub_total_jual',
        //                         )
        //                 ->orderBy('masters.id','desc')
        //                 ->groupBy('satuan_models.nama_satuan','masters.id','masters.code_master','masters.nama_barang')
        //                 ->get();
        // dd($master);        
        return view('warehouse/indexmaster',compact('cabang_id','master','kategori'));
    }
    
    public function indexkategori(){
        $kategori = DB::table('kategori_bahan')->select('id','kategori')->get();
        
        return view('warehouse/indexkategori',compact('kategori'));
    }
    public function inputkat(Request $request){
        $nama = $request->kategori;
        $input = DB::table('kategori_bahan')->insert(['kategori' => $nama]);
        
       return back()->with('success', 'Record Created Successfully.');
    }
    public function editkat(Request $request){
        $id = $request->code_master;
        $idkat = $request->idkat;
        $input = DB::table('masters')->where('code_master',$id)->update(['id_kategori'=> $idkat]);
        
       return back()->with('success', 'Record Created Successfully.');
    }
    public function indexpremix()
    {
        $cabang_id = Auth::user()->cabang_id;

        $master = MasterPremix::join('satuan_models','master_premixes.id_satuan','satuan_models.id')
        ->where('cabang_id',$cabang_id)
        ->select('master_premixes.id',
                'master_premixes.code_master',
                'master_premixes.nama_barang',
                'master_premixes.berat',
                'satuan_models.nama_satuan',
                'master_premixes.harga_pokok',
                'master_premixes.margin',
                'master_premixes.harga_jual',
                'master_premixes.stok',
                'master_premixes.sub_total_pokok',
                'master_premixes.sub_total_jual',
                'master_premixes.cabang_id')
                ->orderBy('master_premixes.id','desc')
                ->get();
        // dd($master);        
        return view('warehouse/indexpremix',compact('cabang_id','master'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $satuan = SatuanModel::all();
        $akses = Auth::user()->id_akses;
        $kategori = DB::table('kategori_bahan')->select('id','kategori')->get();
        // dd($akses);
        $date = new DateTime();
        $req = Master::select('code_master')->orderby('created_at','desc')->first();

        if($req != null){
            $bulan = $date->format('m');
            $bulanreq = substr($req->code_master,6,2);
            if($bulan == $bulanreq){
                $pcod = substr($req->code_master,13);
                $codplus = (int)$pcod + 1;
                $codigit = sprintf("%05s",$codplus);
                $kode = 'BRG'.$date->format('dmyHis');
            }else{
                $kode = 'BRG'.$date->format('dmyHis');
            }
        }else{
            $kode = 'BRG'.$date->format('dmyHis');
        }
        return view('warehouse/createmaster',compact('satuan','akses','kode','kategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cabang_id = Auth::user()->cabang_id;
        $akses = Auth::user()->hak_akses;
        $namabarang = $request->nama_barang;
        $harga_pokok = $request->harga_pokok;
        $idkat = $request->id_kategori;
        $margin = $request->margin;
        $code_master = $request->code_master;
        $stok = "0";
        // $bahanbaku = BahanbakuModel::where('id',$id)->get();
        // $harga_pk = $bahanbaku->harga_pk;
        // $harga_up = $bahanbaku->harga_up;
        // $harga_new = ($harga_pk * ($harga_up/100));

        $request->validate([
            // 'addmore.*.code_master' => $code_master,
            // 'addmore.*.nama_barang' => $namabarang,
            'addmore.*.berat',
            'addmore.*.id_satuan',
            'addmore.*.harga_pokok',
            'addmore.*.margin',
            'addmore.*.harga_jual',
            'addmore.*.stok' ,
            'addmore.*.sub_total_pokok',
            'addmore.*.sub_total_jual',
            // 'addmore.*.id_cabang' => $cabang_id
            
        ]);
    
        foreach ($request->addmore as $key => $value) {
                $insert = Master::create([
                    'code_master' => $code_master,
                    'nama_barang' => $namabarang,
                    'berat' => $value['berat'],
                    $berats = $value['berat'],
                    'id_satuan' => $value['id_satuan'],
                    'id_kategori' =>$idkat,
                    'harga_pokok' => $harga_pokok/$berats,
                    $pokok = $harga_pokok/$berats, 
                    'margin' => $value['margin'],
                    $margins =  $pokok * ($value['margin']/100),
                    'harga_jual' => $harga_pokok/$berats + $margins,
                    'stok' => "0",
                    $jual = $harga_pokok/$berats + $margins,
                    'sub_total_pokok' => $harga_pokok/$berats * 0,
                    'sub_total_jual'=> $jual * 0,
                    'id_cabang' => $cabang_id,
    
                ]);
            }
            // dd($jual);
            // dd($insert);
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
    public function detailpre(Request $request){
    $code = $request->code;
    $detail = ElementPremix::join('masters','element_premixes.id_barang','masters.id')
    ->join('satuan_models','element_premixes.id_satuan','satuan_models.id')
    ->where('element_premixes.code_barang_model',$code)
    ->select('element_premixes.id',
            'element_premixes.code_barang_model',
            'masters.nama_barang',
            'element_premixes.berat',
            'element_premixes.subtotal',
            'satuan_models.nama_satuan')
            ->get();
            // dd($detail);
    $total = ElementPremix::where('code_barang_model',$code)->sum('subtotal'); 
    // dd($detail);
    return view('warehouse.detail',compact('code','detail','total'));
    }
    
    public function hapus(Request $request){
     $code_masters =  $request->code_masters;
    //  dd($code_masters);
     $masters = Master::where('code_master',$code_masters)->delete();
     $cek = ElementPremix::where('code_barang_model',$code_masters)->count();
     if($cek){
         $hapus = ElementPremix::where('code_barang_model',$code_masters)->delete();
     }else{
         
     }
    //  dd($masters);
     return back()->with('success', 'Record delete Successfully.');
    }
    public function editmas(Request $request){
        $codemas = $request->code_master;
        $idkat = $request->idkat;
        $edit = Master::where('code_master',$codemas)->update(['id_kategori' => $idkat]);
        
         return back()->with('success', 'Record delete Successfully.');
    }
    public function restok(Request $request){
         $id = $request->id;
         $nilais = $request->nilai;
         $id_barang = $request->code_barang_model;
         $cek = ElementPremix::where('code_barang_model',$id_barang)->count();
        //  dd($cek);
         if($cek){
            $ceka = ElementPremix::where('code_barang_model',$id_barang)->get();
        //  dd($ceka);
         foreach($ceka as $ceks){
             $id = $ceks->id_barang;
             $berat = $ceks->berat;
             $qty = $nilais * $berat;
        
         }
        //  dd($id_barang);
         $updater_ = Master::where('code_master',$id_barang)->update(['stok' => DB::raw("stok + $nilais"),'sub_total_pokok'=> DB::raw("stok * harga_pokok"),'sub_total_jual'=> DB::raw("stok * harga_jual")]);
         $update_ = Master::where('id',$id)->update(['stok' => DB::raw("stok - $qty"),'sub_total_pokok'=> DB::raw("stok * harga_pokok"),'sub_total_jual'=> DB::raw("stok * harga_jual")]);
            $get_masters = Master::where('id',$id)->select('code_master','berat','stok','harga_pokok')->get();
            foreach($get_masters as $get_mas){
                $code_masters = $get_mas->code_master;
                $berats = $get_mas->berat;
                $stok = $get_mas->stok;
                $harga  = $get_mas->harga_pokok;
            }
            // dd($harga);
           
            // $update_stok = Master::where('code_master',$code_masters)
            // ->where('berat','=',$berats)
            // ->update(['stok' => DB::raw("stok + $qty"),'sub_total_pokok'=> DB::raw("stok * harga_pokok"),'sub_total_jual'=> DB::raw("stok * harga_jual")]);
            $update_stok = Master::where('code_master',$code_masters)
            ->where('berat','>',$berats)
            ->update(['stok'=> DB::raw("(berat/$berats) * $stok"),'sub_total_pokok'=> DB::raw("stok * harga_pokok"),'sub_total_jual'=> DB::raw("stok * harga_jual")]);
            $updat_stok  = Master::where('code_master',$code_masters)
            ->where('berat','<',$berats)
            ->update(['stok'=> DB::raw("($stok/$berats)* berat"),'sub_total_pokok'=> DB::raw("stok * harga_pokok"),'sub_total_jual'=> DB::raw("stok * harga_jual")]);
         }else{
             
            $update_ = Master::where('id',$id)->update(['stok' => DB::raw("stok + $nilais"),'sub_total_pokok'=> DB::raw("stok * harga_pokok"),'sub_total_jual'=> DB::raw("stok * harga_jual")]);
            $get_masters = Master::where('id',$id)->select('code_master','berat','stok','harga_pokok')->get();
            foreach($get_masters as $get_mas){
                $code_masters = $get_mas->code_master;
                $berats = $get_mas->berat;
                $stok = $get_mas->stok;
                $harga  = $get_mas->harga_pokok;
            }
         
            // $update_stok = Master::where('code_master',$code_masters)
            // ->where('berat','=',$berats)
            // ->update(['stok' => DB::raw("stok + $qty"),'sub_total_pokok'=> DB::raw("stok * harga_pokok"),'sub_total_jual'=> DB::raw("stok * harga_jual")]);
            $update_stok = Master::where('code_master',$code_masters)
            ->where('berat','>',$berats)
            ->update(['stok'=> DB::raw("(berat/$berats) * $stok"),'sub_total_pokok'=> DB::raw("stok * harga_pokok"),'sub_total_jual'=> DB::raw("stok * harga_jual")]);
            $updat_stok  = Master::where('code_master',$code_masters)
            ->where('berat','<',$berats)
            ->update(['stok'=> DB::raw("($stok/$berats)* berat"),'sub_total_pokok'=> DB::raw("stok * harga_pokok"),'sub_total_jual'=> DB::raw("stok * harga_jual")]);
         }
        

            
            
        
         return back()->with('success', 'Record Created Successfully.');
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
