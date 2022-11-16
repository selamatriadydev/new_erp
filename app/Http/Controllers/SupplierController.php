<?php

namespace App\Http\Controllers;

use App\SupplierModel;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = SupplierModel::all();
        return view('supplier.index',compact('supplier'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier/create');
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
            'addmore.*.nama_supplier' => 'required',
            'addmore.*.no_hp' => 'required',
            'addmore.*.alamat' => 'required'
        ]);
    
        foreach ($request->addmore as $key => $value) {
            SupplierModel::create([
                'nama_supplier' => $value['nama_supplier'],
                'no_hp' => $value['no_hp'],
                'alamat' => $value['alamat']

            ]);
           
        }
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
        $supplier = SupplierModel::find($id);
        return view('supplier.edit',compact('supplier'));
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
        $supplier = SupplierModel::find($id);
        $supplier->update($request->all());
        return redirect(route('supplier.index'))->with('pesan','berhasil di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SupplierModel::find($id)->delete();
        return back()->with('pesan','berhasil di hapus');
    }
}
