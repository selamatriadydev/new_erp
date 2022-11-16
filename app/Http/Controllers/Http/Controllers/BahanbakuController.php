<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BahanbakuModel;
use App\ItemModel;
use App\KomposisiModel;
use App\PaketModel;
use App\SatuanModel;
use App\CabangModel;
use App\GudangModel;
use DB;

class BahanbakuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $bahanbaku = BahanbakuModel::join('satuan_models','bahanbaku.id_satuan','satuan_models.id')
                                    ->select('bahanbaku.id','bahanbaku.nama_bahanbaku','bahanbaku.harga_pk','bahanbaku.harga_up','bahanbaku.berat','satuan_models.nama_satuan')
                                    ->get();
                                    // dd($bahanbaku);
        return view('bahanbaku.index',compact('bahanbaku'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $satuan = SatuanModel::all();
        $cabang = CabangModel::all();
        return view('bahanbaku.create',compact('cabang','satuan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'addmore.*.nama_bahanbaku' => 'required',
            'addmore.*.harga_pk' => 'required',
            'addmore.*.harga_up' => 'required',
            'addmore.*.berat' => 'required',
            'addmore.*.id_satuan' => 'required'
        ]);
    
        foreach ($request->addmore as $key => $value) {
            BahanbakuModel::create($value);
           
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
        $satuan = SatuanModel::all();
        $bahanbaku = BahanbakuModel::find($id);
        return view('bahanbaku.edit',compact('bahanbaku','satuan'));
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
        $bahanbaku = BahanbakuModel::find($id);
        $id = $bahanbaku->id;
        $harga_pk = $request->harga_pk;
        $harga_up = $request->harga_up;
        $bahanbaku->update($request->all());
        // dd($harga_up);
        // $stok = GudangModel::where('id_bahanbaku',$id)->select('stok')->get();
        $gudang = GudangModel::where('id_bahanbaku',$id)->update(['harga_pk'=>$harga_pk,'margin'=> ($harga_pk*$harga_up/100),'sub_total'=> DB::raw("margin * stok")]);
        // dd($gudang);
        return redirect(route('bahanbaku.index'))->with('pesan','berhasil di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BahanbakuModel::find($id)->delete();
        return back()->with('pesan','berhasil di hapus');
    }
}
