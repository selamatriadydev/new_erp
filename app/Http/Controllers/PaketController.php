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
use DateTime;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cabang = Auth::user()->cabang_id;
        $paket = PaketModel::where('cabang_id',$cabang)->get();

        return view('paket/index',compact('paket','cabang'));
    }

    public function detail($id){
        $det = PaketModel::find($id);
        $id = $det->id;
        $id_kom = $det->code_komponen;
        $inti = IntiKomponenModel::where('code_komponen',$id_kom)->get();
        // dd($inti);
        foreach($inti as $in){
            $nama = $in->nama_komponen;
        }
        // $cek = PaketModel::where('code_komponen','=',"")->count();
        // dd($cek);
        if($id_kom == ""){
            return redirect()->back() ->with('alert', 'Komponen sesuai abstraksi customer!');
        }
        else{
         $komponen = KomponenModel::join('item_models','komponen_models.id_item','item_models.id')
        ->where('komponen_models.code_komponen',$id_kom)
        ->select('item_models.nama_item','komponen_models.hpp','komponen_models.harga_jual','item_models.gambar')
        ->get(); 
        }
        
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
        $item = ItemModel::where('cabang_id',$cabang)->get();
        $komponen = IntiKomponenModel::where('cabang_id',$cabang)->get();
        $date = new DateTime();
        $req = ItemModel::select('code_item')->orderby('created_at','desc')->first();

        if($req != null){
            $bulan = $date->format('m');
            $bulanreq = substr($req->code_master,6,2);
            if($bulan == $bulanreq){
                $pcod = substr($req->code_master,13);
                $codplus = (int)$pcod + 1;
                $codigit = sprintf("%05s",$codplus);
                $kode = 'PKT'.$date->format('His');
            }else{
                $kode = 'PKT'.$date->format('His');
            }
        }else{
            $kode = 'PKT'.$date->format('His');
        }
      
        return view('paket/create',compact('cabang','item','komponen','req','kode'));
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
        $paket->code_paket = $request->code_paket;
        $paket->nama_paket = $request->nama_paket;
        $paket->jenis_paket = $request->jenis_paket;
        // dd($request->jenis_paket);
        if($request->jenis_paket == "Khusus"){

            $paket->code_komponen = "";
            $paket->hpp = "0";
            $paket->harga_jual = "0";
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
        }


        elseif($request->jenis_paket == "Biasa")
        {

            $paket->code_komponen = $request->code_komponen;
            // dd($request->code_komponen);
            $id = $request->code_komponen;
            // dd($id);
            $komponen = IntiKomponenModel::where('code_komponen',$id)->get();
            foreach($komponen as $kom){
                $hpp = $kom->total_hpp;
                $jual = $kom->total_harga_jual;
            }
            $paket->hpp = $hpp;
            $paket->harga_jual = $request->harga_jual;
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
        }else{
            
        }

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
        return view('paket.edit',compact('paket','item'));
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
        $cabang = Auth::user()->cabang_id;
        $paket = PaketModel::find($id);
        $paket->nama_paket = $request->nama_paket;
        $paket->id_komponen = $request->id_komponen;
        $paket->hpp = $request->hpp;
        $paket->harga_jual = $request->harga_jual;
        $paket->cabang_id = $cabang;
        // $or = print_r (explode(",",$paket->isi));
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
        return redirect(route('paket.index'))->with('update','berhasil di edit');
    }
     public function ubah(Request $request)
    {
        $code = $request->code_paket;
        $hpp = $request->hpp;
        $harga = $request->harga_jual;
        $nama = $request->nama_paket;
        $paket = PaketModel::where('code_paket',$code)->update(['harga_jual' =>$harga,'nama_paket'=>$nama,'hpp' => $hpp]);
        
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
