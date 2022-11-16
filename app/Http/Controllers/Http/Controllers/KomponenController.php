<?php

namespace App\Http\Controllers;

use App\IntiKomponenModel;
use App\ItemModel;
use App\KomponenModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class KomponenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tampil = IntiKomponenModel::all();
        return view('komponen/index',compact('tampil'));
    }

    public function detail($id){
        $det = IntiKomponenModel::find($id);
        $nama = $det->nama_komponen;
        $komponen = KomponenModel::join('item_models','komponen_models.id_item','item_models.id')
        ->where('komponen_models.nama_komponen',$nama)
        ->select('item_models.nama_item','komponen_models.hpp','komponen_models.harga_jual')
        ->get();
        
        return view('komponen.detail',compact('det','nama','komponen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = ItemModel::all();
        $cabang = Auth::user()->cabang_id;
        return view('komponen/create',compact('item','cabang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nama_komponen  = $request->nama_komponen;
        $cabang_id      = Auth::user()->cabang_id;
        

        foreach($request->id_item as $key => $value)
        {
            $input = new KomponenModel(); 
            $input->nama_komponen = $nama_komponen; 
            $input->id_item = $value; 
            $item = ItemModel::where('id',$value)->get();
            foreach($item as $items){
                $id = $items->id;
                $hpp = $items->hpp;
                $harga_jual = $items->harga_jual;


            }

            $input->hpp = $hpp;
            $input->total_hpp = $hpp;
            $input->harga_jual = $harga_jual;
            $input->total_harga_jual = $harga_jual;
            $input->cabang_id =$cabang_id;
            $input->save();
        }
        $tot = KomponenModel::where('nama_komponen',$nama_komponen)->sum('hpp');
        $totot = KomponenModel::where('nama_komponen',$nama_komponen)->sum('harga_jual');
        IntiKomponenModel::create([
                'nama_komponen' => $nama_komponen,
                'total_hpp' => $tot,
                'total_harga_jual' => $totot,
                'cabang_id' =>  $cabang_id

            ]);
        // dd($berat);
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
