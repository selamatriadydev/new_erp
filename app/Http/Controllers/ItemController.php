<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use App\ItemModel;
use App\CabangModel;
use App\IntiKomponenModel;
use App\KomposisiModel;
use App\IntiKomposisiModel;
use App\InventoryRetail;
use DB;
use App\ResepModel;
use DateTime;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $komposisi = KomposisiModel::all();
        $intikomposisi = IntiKomposisiModel::all();
        $resep = ResepModel::all();
        $komponen = IntiKomponenModel::all();
        $kategori = DB::table('kategori_item')->get();
        // $satuan = SatuanModel::all();

        $cabang = Auth::user()->cabang_id;
        $item = ItemModel::join('resep_models','item_models.id_resep','resep_models.id')
        ->join('kategori_item','item_models.id_kategori','kategori_item.id')
        ->where('cabang_id',$cabang)
        ->select('item_models.id',
        'item_models.code_item',
        'item_models.nama_item',
        'resep_models.nama_resep',
        'kategori_item.kategori',
        'item_models.hpp',
        'item_models.harga_jual',
        'item_models.gambar')
        ->get();
        return view('item/index',compact('item','cabang','komposisi','intikomposisi','resep','komponen','kategori'));
    }

    public function detail($id){
        $item = ItemModel::find($id);
        $resep = $item->id_resep;
        $tot = $item->hpp;
        // dd($resep);
        $komposisi = KomposisiModel::join('bahanbaku','komposisi_models.id_bahanbaku','bahanbaku.id')
        ->join('satuan_models','komposisi_models.id_satuan','satuan_models.id')
        ->where('id_resep',$resep)
        ->select('bahanbaku.nama_bahanbaku',
        'komposisi_models.gramasi',
        'satuan_models.nama_satuan',
        'komposisi_models.total_harga_up')
        ->get();

        // dd($komposisi);
        return view('item.detail',compact('item','resep','komposisi','tot'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cabang = Auth::user()->cabang_id;
        $komposisi = KomposisiModel::all();
        $intikomposisi = IntiKomposisiModel::all();
        $resep = ResepModel::all();
        $komponen = IntiKomponenModel::all();
        $kategori = DB::table('kategori_item')->get();
        // $satuan = SatuanModel::all();

        $date = new DateTime();
        $req = ItemModel::select('code_item')->orderby('created_at','desc')->first();

        if($req != null){
            $bulan = $date->format('m');
            $bulanreq = substr($req->code_master,6,2);
            if($bulan == $bulanreq){
                $pcod = substr($req->code_master,13);
                $codplus = (int)$pcod + 1;
                $codigit = sprintf("%05s",$codplus);
                $kode = 'RTQ'.$date->format('dmyHis');
            }else{
                $kode = 'RTQ'.$date->format('dmyHis');
            }
        }else{
            $kode = 'RTQ'.$date->format('dmyHis');
        }
        return view('item/create',compact('cabang','komposisi','intikomposisi','resep','komponen','kode','req','date','kategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cabang = Auth::user()->cabang_id;
        $code = $request->code_item;
        $nama = $request->nama_item;
        $cek = ItemModel::where('cabang_id',$cabang)->where('code_item',$code)->where('nama_item',$nama)->count();
        if($cek){
              return redirect()->back() ->with('alert', 'Item Sudah Ada!');
        }
        else{
        $item = new ItemModel();
        $item->code_item = $request->code_item;
        $item->nama_item = $request->nama_item;
        $item->cabang_id = Auth::user()->cabang_id;
        $item->id_resep = $request->id_resep;
        $item->hpp = $request->hpp;
        $item->harga_jual = $request->harga_jual;
        $item->id_kategori = $request->id_kategori;

        // $resep = $request->id_resep;
        // $komposisi = IntiKomposisiModel::where('id_resep',$resep)->get();
        // foreach($komposisi as $kom){
        //     $id = $kom->id;
        //     $hpp = $kom->hpp;
        // }
        // $item->hpp = $hpp;
        // $margin = $request->harga_jual;
        // $item->harga_jual =($hpp*($margin/100));
        // // $item->id_komponen = $request->id_komponen;
        // // $item->id_komposisi = $request->id_komposisi;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $name = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('/images/'.$name);
            $img = Image::make($file)->resize(200, 100, function($constraint) {
            $constraint->aspectRatio();
            });
            $img->save($destinationPath);
            $item->gambar = $name;

        }else{
            $item->gambar = $request->gambar;
        }


        $item->save();
        }
        // dd($request->addmore);
    
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
        $item = ItemModel::find($id);
        $resep = ResepModel::all();
        $kategori = DB::table('kategori_item')->get();
        return view('item.edit',compact('item','resep','kategori'));
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
        $item = ItemModel::find($id);
        $item->hpp = $request->hpp;
        // dd($request->hpp);
        $code =  $request->code_item;
        $item->harga_jual = $request->harga_jual;
        $hargaup = $request->harga_jual;
        $item->nama_item = $request->nama_item;
        $item->id_resep = $request->id_resep;
        $item->id_kategori = $request->id_kategori;
        $idres = $request->id_resep;
        $inti = IntiKomposisiModel::where('id_resep',$idres)->select('hpp')->get();
        $cek = IntiKomposisiModel::where('id_resep',$idres)->select('hpp')->count();
        // dd($inti);
        foreach($inti as $in){
            $hpp = $in->hpp;
        }
        dd($hpp);
        if($cek == "0"){
            $item->hpp = $request->hpp;
        }
        else{
            $item->hpp = $hpp;
        }
        

        $item->update();
        if($hpp == "0"){
           $update_inventory = InventoryRetail::where('code_item',$code)->update(['harga_pk'=>"0",'harga_up'=>$hargaup,'subtotal_up' => DB::raw("stok * $hargaup")]);
        }
        else{
           $update_inventory = InventoryRetail::where('code_item',$code)->update(['harga_pk'=>$hpp,'harga_up'=>$hargaup,'subtotal_up' => DB::raw("stok * $hargaup")]);
        }
        
        // DD($update_inventory);
        return redirect(route('item.index'))->with('pesan','berhasil di ubah');
    }

    public function edit_item(Request $request){
        $id = $request->id;
        $code = $request->code_item;
        $hpp = $request->hpp;
        $jual = $request->harga_jual;
        $resep = $request->id_resep;
        $kategori = $request->id_kategori;
        $item = $request->nama_item;
        $update_item = ItemModel::where('id',$id)->update(['nama_item'=> $item,'hpp' =>$hpp,'harga_jual' => $jual,'id_resep'=>$resep,'id_kategori'=>$kategori]);
        $update_inventory = InventoryRetail::where('code_item',$code)->update(['harga_pk'=>$hpp,'harga_up'=>$jual,'subtotal_up' => DB::raw("stok * $jual")]);
        
        return back()->with('pesan','berhasil di update');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ItemModel::find($id)->delete();
        return back()->with('pesan','berhasil di hapus');
    }
}
