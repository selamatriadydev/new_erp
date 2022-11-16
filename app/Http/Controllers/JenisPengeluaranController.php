<?php

namespace App\Http\Controllers;

use App\JenisPengeluaranModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JenisPengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenispengeluaran = JenisPengeluaranModel::all();
        return view('jenispengeluaran/index',compact('jenispengeluaran'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jenispengeluaran/create');
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
        $cek_Data2 = Auth::user()->hak_akses;

        $request->validate([
            'addmore.*.cabang_id' => $cek_Data1,
            'addmore.*.hak_akses' => $cek_Data2,
            'addmore.*.nama_pengeluaran' => 'required'
        ]);
    
        foreach ($request->addmore as $key => $value) {
            JenisPengeluaranModel::create([
                'cabang_id' => $cek_Data1,
                'hak_akses' =>  $cek_Data2,
                'nama_pengeluaran' => $value['nama_pengeluaran']

            ]);
           
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
        $jenis = JenisPengeluaranModel::find($id);
        return view('jenispengeluaran.edit',compact('jenis'));
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
        $jenis = JenisPengeluaranModel::find($id);
        $jenis->update($request->all());
        return redirect(route('jenispengeluaran.index'))->with('pesan','berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        JenisPengeluaranModel::find($id)->delete();
        return back()->with('pesan','berhasil di hapus');
    }
}
