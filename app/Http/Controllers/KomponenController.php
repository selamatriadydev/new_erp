<?php

namespace App\Http\Controllers;

use App\IntiKomponenModel;
use App\ItemModel;
use App\KomponenModel;
use DateTime;
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
        
        $cabang = Auth::user()->cabang_id;
        $tampil = IntiKomponenModel::where('cabang_id',$cabang)->get();
        return view('komponen/index',compact('tampil'));
    }

    public function detail($id){
        $det = IntiKomponenModel::find($id);
        $nama = $det->code_komponen;
        $komponen = KomponenModel::join('item_models','komponen_models.id_item','item_models.id')
        ->where('komponen_models.code_komponen',$nama)
        ->select('item_models.nama_item','komponen_models.hpp','komponen_models.harga_jual')
        ->get();
        // dd($komponen);
        return view('komponen.detail',compact('det','nama','komponen'));
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
        $date = new DateTime();
        $req = KomponenModel::select('code_komponen')->orderby('created_at','desc')->first();

        if($req != null){
            $bulan = $date->format('m');
            $bulanreq = substr($req->code_master,6,2);
            if($bulan == $bulanreq){
                $pcod = substr($req->code_master,13);
                $codplus = (int)$pcod + 1;
                $codigit = sprintf("%05s",$codplus);
                $kode = 'KOM'.$date->format('His');
            }else{
                $kode = 'KOM'.$date->format('His');
            }
        }else{
            $kode = 'KOM'.$date->format('His');
        }
        return view('komponen/create',compact('item','cabang','date','req','kode'));
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
        $code_komponen  = $request->code_komponen;
        $harga_jualf    = $request->harga_jual;
        $cabang_id      = Auth::user()->cabang_id;
        

        foreach($request->id_item as $key => $value)
        {
            $input = new KomponenModel(); 
            $input->code_komponen = $code_komponen; 
            $input->nama_komponen = $nama_komponen; 
            $input->id_item = $value;
            // dd($value);
            $item = ItemModel::where('id',$value)->get();
            // dd($item);
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
        $tot = KomponenModel::where('code_komponen',$code_komponen)->sum('hpp');
        // dd($tot);
        $totot = KomponenModel::where('code_komponen',$code_komponen)->sum('harga_jual');
        IntiKomponenModel::create([
                'nama_komponen' => $nama_komponen,
                'code_komponen' => $code_komponen,
                'total_hpp' => $tot,
                'total_harga_jual' => $harga_jualf,
                'cabang_id' =>  $cabang_id

            ]);
        // dd($code_komponen);
        return back()->with('success', 'Record Created Successfully.');


    }
    public function hapuskomponen(Request $request){
        $id = $request->code_komponen;
        // dd($id);
        $hapuskomponen = KomponenModel::where('code_komponen',$id)->delete();
        $hapusintikomponen = IntiKomponenModel::where('code_komponen',$id)->delete();
        
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
