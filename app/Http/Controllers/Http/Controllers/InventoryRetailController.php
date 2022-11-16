<?php

namespace App\Http\Controllers;

use App\ItemModel;
use App\StokRetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class InventoryRetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        return view('retail/index',compact('user','stok'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user()->cabang_id;
        $item = ItemModel::where('cabang_id',$user)->get();
        return view('retail/create',compact('item','user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cek_Data1 = Auth::user()->cabang_id;
        $gudang = Auth::user()->hak_akses;

        $request->validate([
            'addmore.*.cabang_id' => $cek_Data1,
            'addmore.*.id_product' => 'required',
            'addmore.*.stok',
            'addmore.*.sub_total',
            'addmore.*.sub_totalpk',
            'addmore.*.cabang_id'
            
        ]);
    
        foreach ($request->addmore as $key => $value) {
            $id = $value['id_product'];
            $stok = $value['stok'];
            $item = ItemModel::where('id',$id)->get();
            foreach($item as $items){
                $hpp =  $items->hpp;
                $sub = $hpp * $stok;
                $jual = $items->harga_jual;
                $subup = $jual * $stok;

            }
            
            $cek = StokRetailModel::where('id_product',$id)->count();
            if($cek){
                $up = StokRetailModel::where('id_product',$id)->update([
                    'stok'=> DB::raw("stok + $stok"),
                    'sub_total'=> DB::raw("stok * hpp"),
                    'sub_totalpk'=> DB::raw("stok * harga_jual")
                ]);
            }
            else{
                $insert = StokRetailModel::create([
                    'cabang_id' => $cek_Data1,
                    'id_product' => $value['id_product'],
                    'hpp' => $hpp,
                    'harga_jual' => $jual,
                    'sub_total' => $sub,
                    'sub_totalpk' => $subup,
                    'stok' => $value['stok']
    
                ]);
            }

            
           
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
