<?php

namespace App\Http\Controllers;

use App\BahanbakuModel;
use App\GudangCabangModel;
use App\GudangModel;
use App\SatuanBarangModel;
use App\SatuanModel;
use App\ElementPremix;
use App\Master;
use App\MasterPremix;
use DateTime;
use App\BarangGudang;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cabang = Auth::user()->hak_akses;
        $cabangs = Auth::user()->cabang_id;
        $gudang = BarangGudang::join('satuan_models','barang_gudangs.id_satuan','satuan_models.id')
        ->where('nama_gudang',$cabang)
        ->where('cabang_id',$cabangs)
        ->select('barang_gudangs.id',
                 'barang_gudangs.code_barang_model',
                'barang_gudangs.code_master',
                'barang_gudangs.nama_barang',
                'barang_gudangs.berat',
                'satuan_models.nama_satuan',
                'barang_gudangs.stok',
                'barang_gudangs.harga_pokok',
                'barang_gudangs.margin',
                'barang_gudangs.harga_jual',
                'barang_gudangs.sub_total_pokok',
                'barang_gudangs.sub_total_jual',
                'barang_gudangs.cabang_id',
                'barang_gudangs.nama_gudang')
        ->orderBy('barang_gudangs.nama_barang','asc')
        ->get();
        $stok =  BarangGudang::where('nama_gudang',$cabang)
        ->where('cabang_id',$cabangs)      
        ->sum('stok');
        $sub = BarangGudang::where('nama_gudang',$cabang)
        ->where('cabang_id',$cabangs)
        ->sum('sub_total_jual');
        // dd($gudang);
        return view('gudang/index',compact('gudang','stok','sub','cabang','cabangs'));
    }
    public function detailgudangs($id){
        $details = BarangGudang::find($id);
        $nama = $details->nama_barang;

        // dd($nama);
        // $detail = SatuanBarangModel::join('satuan_models','satuan_barang_models.id_satuan','satuan_models.id')
        // ->where('satuan_barang_models.nama_barang','like',$nama)
        // ->select('satuan_barang_models.id',
        // 'satuan_barang_models.nama_barang',
        // 'satuan_barang_models.stok',
        // 'satuan_models.nama_satuan',
        // 'satuan_barang_models.harga_pk',
        // 'satuan_barang_models.sub_totalpk',
        // 'satuan_barang_models.harga_up',
        // 'satuan_barang_models.sub_total'
        // )
        // ->get();
        // dd($detail);
        return view('gudang/gudangdetails',compact('details','nama'));
    }
    public function restokbarang(Request $request){
        $id_barang = $request->id;
        $berat = $request->berat ;
        $code_master = $request->code_master;
        // dd($code_master);
        $new_stok = $request->new_stok;
        $pengurangan = $berat * $new_stok;
        $baranggudang = BarangGudang::where('id',$id_barang)->update(['stok'=> DB::raw("stok + $new_stok"),'sub_total_pokok'=> DB::raw("stok * harga_pokok"),'sub_total_jual'=> DB::raw("stok * harga_jual")]);
        $barangmaster = Master::where('id',$code_master)->update(['stok' => DB::raw("stok - $pengurangan")]);
        // $cobs = Master::where('id',$code_master)->select('code_master')->get();
        $get_masters = Master::where('id',$code_master)->select('code_master','berat','stok','harga_pokok')->get();
            foreach($get_masters as $get_mas){
                $code_masters = $get_mas->code_master;
                $berats = $get_mas->berat;
                $stok = $get_mas->stok;
                $harga  = $get_mas->harga_pokok;
            }
            // dd($harga);
            $update_stok = Master::where('code_master',$code_masters)
            ->where('berat','>',$berats)
            ->update(['stok'=> DB::raw("(berat/$berats) * $stok"),'sub_total_pokok'=> DB::raw("stok * harga_pokok"),'sub_total_jual'=> DB::raw("stok * harga_jual")]);
            $updat_stok  = Master::where('code_master',$code_masters)
            ->where('berat','<',$berats)
            ->update(['stok'=> DB::raw("($stok/$berats)* berat"),'sub_total_pokok'=> DB::raw("stok * harga_pokok"),'sub_total_jual'=> DB::raw("stok * harga_jual")]);


            return back()->with('success', 'Record Created Successfully.');

    }
    public function gudangcabang(Request $request)
    {
        $pilih = "Gudang Cabang";
        $cabang = Auth::user()->cabang_id;
        $gudang = SatuanBarangModel::
                            join('satuan_models','satuan_barang_mmodels.id_satuan','satuan_models.id')
                            ->where('satuan_barang_models_models.gudang',$pilih)
                            ->where('satuan_barang_models_models.cabang_id',$cabang)
                            ->select('satuan_barang_models_models.id',
                            'satuan_barang_mmodels.nama_barang',
                            'satuan_barang_models_models.harga_pk',
                            'satuan_barang_mmodels.berat',
                            'satuan_models.nama_satuan',
                            'satuan_barang_models_models.harga_up',
                            'satuan_barang_models_models.stok')
                            ->get();
                            // dd
                            
        $stok =  GudangModel::where('gudang',$pilih)
        ->where('cabang_id',$cabang)
        ->sum('stok');
        $sub = GudangModel::where('gudang',$pilih)
        ->where('cabang_id',$cabang)
        ->sum('sub_total');
        // dd($gudang);
        return view('gudangcabang/inventory',compact('stok','sub','gudang','pilih','cabang'));
    }
    
    public function editbarang($id){
        $satuan = SatuanModel::all();
        $gudang = BarangGudang::find($id);
        
        // dd($gudang);
        return view('gudang.editbarang',compact('satuan','gudang'));
    }
    public function updatebarang(Request $request,$id){
        $gudang = BarangGudang::find($id);
        $stok = $gudang->stok;
        $gudang->harga_pokok = $request->harga_pokok;
        $gudang->margin = $request->margin;
        $harga_pokok = $request->harga_pokok;
        $margin = $request->margin;
        $harga_jual = $harga_pokok + $margin;
        $gudang->harga_jual = $harga_pokok + $margin;
        $gudang->sub_total_pokok = $stok * $harga_pokok;
        $gudang->sub_total_jual = $stok * $harga_jual;
        $gudang->save();
        // $ubah = SatuanBarangModel::where('id',$id)->update(['sub_total' => DB::raw('harga_up * stok')]);

        return redirect(route('gudang.index'))->with('pesan','berhasil di ubah');
    }
    public function bigwarehouse(Request $request)
    {
        $pilih = "Admin Bigwarehouse";
        // $cabang = Auth::user()->cabang_id;
        $gudang = BarangGudang::join('satuan_models','barang_gudangs.id_satuan','satuan_models.id')
        ->where('nama_gudang',$pilih)
        ->select('barang_gudangs.id',
        'barang_gudangs.nama_barang',
        'barang_gudangs.harga_pokok',
        'barang_gudangs.margin',
        'barang_gudangs.sub_total_jual',
        'barang_gudangs.stok',
        'barang_gudangs.berat',
        'barang_gudangs.harga_jual',
        'satuan_models.nama_satuan')
        ->get();
        $stok =  BarangGudang::where('nama_gudang',$pilih)
        ->sum('stok');
        $sub = BarangGudang::where('nama_gudang',$pilih)
        ->sum('sub_total_jual');
        return view('gudang/big',compact('stok','sub','gudang','pilih'));
    }
    public function eggwarehouse(Request $request)
    {
        $pilih = "Admin Eggwarehouse";
        $gudang = BarangGudang::join('satuan_models','barang_gudangs.id_satuan','satuan_models.id')
        ->where('nama_gudang',$pilih)
        ->select('barang_gudangs.id',
        'barang_gudangs.nama_barang',
        'barang_gudangs.harga_pokok',
        'barang_gudangs.margin',
        'barang_gudangs.sub_total_jual',
        'barang_gudangs.stok',
        'barang_gudangs.berat',
        'barang_gudangs.harga_jual',
        'satuan_models.nama_satuan')
        ->get();
        $stok =  BarangGudang::where('nama_gudang',$pilih)
        ->sum('stok');
        $sub = BarangGudang::where('nama_gudang',$pilih)
        ->sum('sub_total_jual');
        return view('gudang/egg',compact('stok','sub','gudang','pilih'));
    }
    public function premixwarehouse(Request $request)
    {
        $pilih = "Admin Premixwarehouse";
        $gudang = BarangGudang::join('satuan_models','barang_gudangs.id_satuan','satuan_models.id')
        ->where('nama_gudang',$pilih)
        ->select('barang_gudangs.id',
        'barang_gudangs.nama_barang',
        'barang_gudangs.harga_pokok',
        'barang_gudangs.margin',
        'barang_gudangs.sub_total_jual',
        'barang_gudangs.stok',
        'barang_gudangs.berat',
        'barang_gudangs.harga_jual',
        'satuan_models.nama_satuan')
        ->get();
        $stok =  BarangGudang::where('nama_gudang',$pilih)
        ->sum('stok');
        $sub = BarangGudang::where('nama_gudang',$pilih)
        ->sum('sub_total_jual');
        return view('gudang/premix',compact('stok','sub','gudang','pilih'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $satuan = SatuanModel::all();
        $master = Master::join('satuan_models','masters.id_satuan','satuan_models.id')
        ->select('masters.id',
                    'masters.code_master',
                    'masters.nama_barang',
                'satuan_models.nama_satuan')
                ->orderBy('masters.nama_barang','asc')
                ->get();
        $akses = Auth::user()->id_akses;
        // dd($akses);
        $date = new DateTime();
        $req = BarangGudang::select('code_barang_model')->orderby('created_at','desc')->first();

        if($req != null){
            $bulan = $date->format('m');
            $bulanreq = substr($req->code_master,6,2);
            if($bulan == $bulanreq){
                $pcod = substr($req->code_master,13);
                $codplus = (int)$pcod + 1;
                $codigit = sprintf("%05s",$codplus);
                $kode = 'BRG'.$date->format('His').$codigit;
            }else{
                $kode = 'BRG'.$date->format('His').'0001';
            }
        }else{
            $kode = 'BRG'.$date->format('His').'0001';
        }
        
        return view('gudang/create',compact('satuan','master','kode','req','akses'));
    }

    public function createpremix()
    {
        $satuan = SatuanModel::all();
        $master = MasterPremix::join('satuan_models','master_premixes.id_satuan','satuan_models.id')
        ->select('master_premixes.id',
                    'master_premixes.code_master',
                    'master_premixes.nama_barang',
                'satuan_models.nama_satuan')
                ->get();
        $akses = Auth::user()->id_akses;
        $id_barang = Master::join('satuan_models','masters.id_satuan','satuan_models.id')
        ->select('masters.id',
                 'masters.berat',
                 'masters.nama_barang',
                 'satuan_models.nama_satuan')
                 ->OrderBy('masters.nama_barang','asc')
        ->get();
        // dd($akses);
        $date = new DateTime();
        $req = BarangGudang::select('code_barang_model')->orderby('created_at','desc')->first();

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
        
        return view('gudang/createpremix',compact('satuan','master','kode','req','akses','id_barang'));
    }

    public function storepremix(Request $request)
    {
        $kode_barang = $request->kode_barang;
        $nama_barang = $request->nama_barang;
        $kode_master = $request->code_masters;
        $margin = $request->margin_premix;
        $berat = $request->berat;
        $idkat = $request->id_kat;
        // dd($idkat);
        $id_satuan = $request->id_satuan;
        $stok = $request->stok;
        $harga_ups = $request->harga_up;


        $request->validate([
            'addmore.*.kode_barang' => $kode_barang,
            'addmore.*.id_barang',
            'addmore.*.harga',
            'addmore.*.berat',
            'addmore.*.id_satuan',
            'addmore.*.cabang_id' => Auth::user()->cabang_id
        ]);
    
        foreach ($request->addmore as $key => $value) {
            $barang = Master::where('id',$value['id_barang'])->get();
            // dd($barang);
            foreach($barang as $barangs){
                $harga = $barangs->harga_jual;
                $beratd = $barangs->berat;
                $id    = $barangs->id_satuan;
                $hargas= $harga;
                // dd($hargas);
           
            ElementPremix::create([
                'code_barang_model' => $kode_barang,
                'id_barang' => $value['id_barang'],
                'harga' => $hargas,
                'berat' => $value['berat'],
                $brt = $value['berat'],
                'id_satuan' => $id,
                'cabang_id' => Auth::user()->cabang_id,
                'subtotal' => $hargas * $brt
            ]);
            }
           
        }
        

        $sumel = ElementPremix::where('code_barang_model',$kode_barang)->sum('subtotal');
        $hargaj = ($sumel *($margin/100));
        $jju = $sumel + $hargaj;
        Master::create([
            'code_master' => $kode_barang,
            'nama_barang' => $nama_barang,
            'berat' => $berat,
            'id_satuan' => $id_satuan,
            'harga_pokok' => $sumel,
            'id_kategori' => "6",
            'margin' => $margin,
            'harga_jual' => $harga_ups,
            'stok' => "0",
            'sub_total_pokok' => $sumel * "0",
            'sub_total_jual' => $harga_ups * "0",
            'id_cabang' => Auth::user()->cabang_id,
            
            
            // 'code_barang_model' => $kode_barang,
            // 'code_master' => "1",
            // 'nama_barang' => $nama_barang,
            // 'berat' => $berat,
            // 'id_satuan' => $id_satuan,
            // 'stok' => $stok,
            // 'harga_pokok' => $sumel,
            // 'margin' => $margin,
            // 'harga_jual' => $jju,
            // 'sub_total_pokok' => $sumel * "0",
            // 'sub_total_jual' => $jju * "0",
            // 'cabang_id' => Auth::user()->cabang_id,
            // 'nama_gudang' => Auth::user()->hak_akses

        ]);
        

        // dd($barang);
    
        return back()->with('success', 'Record Created Successfully.');
    
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = new BarangGudang();
        $input->code_barang_model = $request->kode_barang;
        $input->code_master = $request->code_masters;
        $code = $request->code_masters;
        // dd($code);
        $berat = $request->berat;
        $stok = "0";
        $margin = $request->margin;
        
        $master = Master::where('id',$code)->get();
        foreach($master as $mas){
            $harga_p = $mas->harga_pokok;
            $nama = $mas->nama_barang;
            $satuan = $mas->id_satuan;
            $harga_modal = $harga_p * $berat;
            $nilaimargin = $harga_modal * ($margin/100);
            $harga_jual = $harga_modal + $nilaimargin;
            $subtotal_modal  = $harga_modal * $stok;
            $subtotal_jual = $harga_jual * $stok;
            // dd($nama);
            
        $input->nama_barang = $nama;
        $input->berat = $berat;
        $input->id_satuan = $satuan;
        $input->stok = $stok;
        $input->harga_pokok = $harga_modal;
        $input->margin = $margin;
        $input->harga_jual = $harga_jual;
        $input->sub_total_pokok = $subtotal_modal;
        $input->sub_total_jual = $subtotal_jual;
        
        }
        $input->cabang_id = Auth::user()->cabang_id;
        $input->nama_gudang = Auth::user()->hak_akses;
        $input->save();
        // dd($request->code_masters);
    
        return back()->with('success', 'Record Created Successfully.');
    
    }
    
    public function restok(Request $request){
         $id = $request->id;
         $nilai = $request->nilai;
         $id_barang = $request->code_barang_model;
         $cek = ElementPremix::where('code_barang_model',$id_barang)->count();
         dd($cek);
         $update_ = Master::where('id',$id)->update(['stok' => DB::raw("stok + $nilai"),'sub_total_pokok'=> DB::raw("stok * harga_pokok"),'sub_total_jual'=> DB::raw("stok * harga_jual")]);
            $get_masters = Master::where('id',$id)->select('code_master','berat','stok','harga_pokok')->get();
            foreach($get_masters as $get_mas){
                $code_masters = $get_mas->code_master;
                $berats = $get_mas->berat;
                $stok = $get_mas->stok;
                $harga  = $get_mas->harga_pokok;
            }
            // dd($harga);
            if($harga_new > $harga){
                $update_harga = Master::where('id',$id)->update(['harga_pokok' => DB::raw("$harga_new"),'harga_jual' => DB::raw("$harga_new + margin")]);
                $update_harga2 = Master::where('code_master',$code_masters)
                                        ->where('berat','>',$berats)
                                        ->update(['harga_pokok' => DB::raw("$harga_new/(berat/$berats)"),'harga_jual' => DB::raw("harga_pokok + margin")]);
                $update_hargas = Master::where('code_master',$code_masters)
                                        ->where('berat','<',$berats)
                                        ->update(['harga_pokok' => DB::raw("$harga_new*($berats/berat)"),'harga_jual' => DB::raw("harga_pokok + margin")]);
                                        
            }else{
            
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

            
            
        
         return back()->with('success', 'Record Created Successfully.');
    }
    
    
    public function restokpremix(Request $request){
         $ids = $request->id;
         $nilais = $request->nilai;
         $id_barang = $request->code_barang_model;
         $cek = ElementPremix::where('code_barang_model',$id_barang)->get();
        //  dd($cek);
         foreach($cek as $ceks){
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
        $satuan = SatuanModel::all();
        $gudang = BarangGudang::find($id);
        return view('gudang.edit',compact('satuan','gudang'));
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
        $gudang = BarangGudang::find($id);
        $margin = $gudang->margin;
        $gudang->nama_barang = $request->nama_barang;
        $gudang->harga_pk = $request->harga_pk; 
        $pk = $request->harga_pk;
        $gudang->harga_up = (($margin/100) * $pk);
        $up = $gudang->harga_up;
        $gudang->nama_barang = $request->nama_barang;
        $gudang->berat = $request->berat;
        $gudang->id_satuan = $request->id_satuan;
        $gudang->stok = $request->stok;
        $stok = $request->stok;
        $gudang->sub_totalpk = ($pk * $stok);
        $gudang->sub_total = ($up * $stok);
        $gudang->save();
        return redirect(route('gudang.index'))->with('pesan','berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BarangGudang::find($id)->delete();
        return back()->with('pesan','berhasil di hapus');
    }
}
