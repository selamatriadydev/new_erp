<?php

namespace App\Http\Controllers;

use App\PaketModel;
use Illuminate\Http\Request;
use App\CabangModel;
use App\IntiKomponenModel;
use App\ItemModel;
use App\KomponenModel;
use Image;
use Illuminate\Support\Facades\Auth;
class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paket = PaketModel::all();

        return view('paket/index',compact('paket'));
    }

    public function detail($id){
        $det = PaketModel::find($id);
        $id = $det->id;
        $id_kom = $det->code_komponen;
        $inti = IntiKomponenModel::where('id',$id_kom)->get();
        foreach($inti as $in){
            $nama = $in->nama_komponen;
        }
        $komponen = KomponenModel::join('item_models','komponen_models.id_item','item_models.id')
        ->where('komponen_models.nama_komponen',$nama)
        ->select('item_models.nama_item','komponen_models.hpp','komponen_models.harga_jual','item_models.gambar')
        ->get();
        // dd($nama);
        
        return view('paket.detail',compact('det','id','id_kom','inti','nama','komponen'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cabang = Auth::user()->cabang_id;
        $item = ItemModel::all();
        $komponen = IntiKomponenModel::all();
      
        return view('paket/create',compact('cabang','item','komponen'));
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
        $paket = new PaketModel();
        $paket->nama_paket = $request->nama_paket;
        $paket->code_komponen = $request->code_komponen;
        $id = $request->code_komponen;

        $komponen = IntiKomponenModel::where('id',$id)->get();
        foreach($komponen as $kom){
            $hpp = $kom->total_hpp;
            $jual = $kom->total_harga_jual;
        }
        $paket->hpp = $hpp;
        $paket->harga_jual = $jual;
        $paket->cabang_id = $cabang;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $name = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('/images/'.$name);
            $img = Image::make($file)->resize(200, 100, function($constraint) {
            $constraint->aspectRatio();
            });
            $img->save($destinationPath);
            $paket->gambar = $name;

        }else{
            $paket->gambar = $request->gambar;
        }
        
        
        $paket->save();
        // dd($or);
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
        $item = ItemModel::all();
        $paket = PaketModel::find($id);
        $komponen = IntiKomponenModel::all();
        return view('paket.edit',compact('paket','item','komponen'));
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
        // $cabang = Auth::user()->cabang_id;
        // $paket = PaketModel::find($id);
        // $paket->code_paket = $request->code_paket;
        // $paket->nama_paket = $request->nama_paket;
        // $paket->code_komponen = $request->code_komponen;
        // $paket->jenis_paket = $request->jenis_paket;
        // $paket->hpp = $request->hpp;
        // $paket->harga_jual = $request->harga_jual;
        // $paket->cabang_id = $cabang;
        
        // $paket->update();
        // dd($id_komponen);
       return view('ini konyol');
    }

    public function ubah(Request $request)
    {
        $code = $request->code_paket;
        $harga = $request->harga_jual;
        $nama = $request->nama_paket;
        $paket = PaketModel::where('code_paket',$code)->update(['harga_jual' =>$harga,'nama_paket'=>$nama]);
        
         return back()->with('success', 'Record Created Successfully.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PaketModel::find($id)->delete();
        return back()->with('pesan','berhasil di hapus');
    }
}
