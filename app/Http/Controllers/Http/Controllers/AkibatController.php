<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AkibatModel;
class AkibatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $akibat = AkibatModel::all();
        return view('akibat.index',compact('akibat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('akibat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        AkibatModel::create($request->all());
        return redirect(route('akibat.index'))->with('pesan','berhasil di tambah');
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
        $akibat = AkibatModel::find($id);
        return view('akibat.edit',compact('akibat'));
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
        $akibat = AkibatModel::find($id);
        $akibat->update($request->all());
        return redirect(route('akibat.index'))->with('pesan','berhasil di tambah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AkibatModel::find($id)->delete();
        return back()->with('pesan','berhasil di hapus');
    }
}
