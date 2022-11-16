<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PenyebabModel;
class PenyebabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penyebab = PenyebabModel::all();
        return view('penyebab.index',compact('penyebab'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('penyebab.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        PenyebabModel::create($request->all());
        return redirect(route('penyebab.index'))->with('pesan','berhasil di tambah');
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
        $penyebab = PenyebabModel::find($id);
        return view('penyebab.edit',compact('penyebab'));
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
        $penyebab = PenyebabModel::find($id);
        $penyebab->update($request->all());
        return redirect(route('penyebab.index'))->with('pesan','berhasil di tambah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PenyebabModel::find($id)->delete();
        return back()->with('pesan','berhasil di hapus');
    }
}
