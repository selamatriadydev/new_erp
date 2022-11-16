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
use App\ResepModel;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cabang = Auth::user()->cabang_id;
        $item = ItemModel::join('resep_models','item_models.id_resep','resep_models.id')
        ->where('cabang_id',$cabang)
        ->select('item_models.id',
        'item_models.nama_item',
        'resep_models.nama_resep',
        'item_models.hpp',
        'item_models.harga_jual',
        'item_models.gambar')
        ->get();
        return view('item/index',compact('item','cabang'));
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
        return view('item/create',compact('cabang','komposisi','intikomposisi','resep','komponen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new ItemModel();
        $item->nama_item = $request->nama_item;
        $item->cabang_id = Auth::user()->cabang_id;
        $item->id_resep = $request->id_resep;
        $resep = $request->id_resep;
        $komposisi = IntiKomposisiModel::where('id_resep',$resep)->get();
        foreach($komposisi as $kom){
            $id = $kom->id;
            $hpp = $kom->hpp;
        }
        $item->hpp = $hpp;
        $margin = $request->harga_jual;
        $item->harga_jual =($hpp*($margin/100));
        // $item->id_komponen = $request->id_komponen;
        // $item->id_komposisi = $request->id_komposisi;
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
        return view('item.edit',compact('item'));
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
        $item->update($request->all());
        return redirect(route('item.index'))->with('pesan','berhasil di ubah');
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
