<?php

namespace App\Http\Controllers;

use App\BahanbakuModel;
use App\IntiKomposisiModel;
use Illuminate\Http\Request;
use App\BarangGudang;
use App\KomposisiModel;
use App\Master;
use App\ResepModel;
use App\SatuanModel;

class KomposisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $komposisi = IntiKomposisiModel::join('resep_models','inti_komposisi_models.id_resep','resep_models.id')
        ->select('inti_komposisi_models.id','resep_models.nama_resep','inti_komposisi_models.hpp')
        ->get();

        return view('komposisi/index',compact('komposisi'));
    }

    public function detail($id){
        $kom = IntiKomposisiModel::find($id);
        $id = $kom->id;
        $resep = $kom->id_resep;

        $komposisi = KomposisiModel::join('masters','komposisi_models.id_bahanbaku','masters.id')
        ->join('satuan_models','komposisi_models.id_satuan','satuan_models.id')
        ->where('id_resep',$resep)
        ->select('masters.nama_barang',
        'komposisi_models.harga_up',
        'komposisi_models.quantity',
        'komposisi_models.total_harga_up',
        'komposisi_models.gramasi',
        'komposisi_models.hasil_jadi',
        'satuan_models.nama_satuan')
        ->get();

        return view('komposisi.detail',compact('kom','id','resep','komposisi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bahanbaku = Master::join('satuan_models','masters.id_satuan','satuan_models.id')->select('masters.id','masters.nama_barang','masters.berat','satuan_models.nama_satuan')
        ->OrderBy('masters.nama_barang','asc')
        ->get();
        $resep = ResepModel::orderBy('nama_resep','asc')->get();
        $satuan = SatuanModel::all();
        return view('komposisi/create',compact('bahanbaku','resep','satuan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_resep  = $request->id_resep;
        $hasil_jadi = $request->hasil_jadi;
        

        foreach($request->id_bahanbaku as $key => $value)
        {
            $input = new KomposisiModel(); 
            $input->id_resep = $id_resep; 
            $input->id_bahanbaku = $value; 
            $bahanbaku = Master::where('id',$value)->get();
            foreach($bahanbaku as $items){
                $id = $items->id;
                $pk = $items->harga_pokok;
                $up = $items->harga_jual;
                $satuan = $items->id_satuan;
                $berat = $items->berat;
                $margin = ($pk*$up);


            }
            // dd($up);

            $input->harga_up = $margin;
            $input->quantity = $request->quantity[$key];
            $input->hasil_jadi = $hasil_jadi;
            $qty = $request->quantity[$key];
            $input->gramasi = ($qty/$hasil_jadi);
            $gramasi = ($qty/$hasil_jadi);
            $input->total_harga_up = ($up*$gramasi);
            $input->id_satuan = $satuan;
            $input->save();
        }
        $hpp = KomposisiModel::where('id_resep',$id_resep)->sum('total_harga_up');
        IntiKomposisiModel::create([
                'id_resep' => $id_resep,
                'hpp' => $hpp
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
