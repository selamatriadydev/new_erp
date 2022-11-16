<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseModel;
use App\PurchasingModel;
use App\SatuanModel;
use App\BahanbakuModel;
use App\PembayaranpurchModel;
use App\CabangModel;
use DateTime;
use DB;
use Illuminate\Support\Facades\Auth;
class InputBayarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $find = PurchasingModel::all();
        $no_purch = $find->no_purchase;
        // dd($no_purch);
        return view('bayar/create',compact('find','no_purch'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = new PembayaranpurchModel();
        $input->no_purchase = $request->no_purchase;
        $input->nominal = $request->nominal;
        $input->save();
        $no_purchase = $request->no_purchase;
        $nominal = $request->nominal;

        $up = PurchasingModel::where('no_purchase',$no_purchase)->update([
            'qty'=> DB::raw("big_total + $nominal")
        ]);
        // dd($no_purch);
        return view('purchase/index',compact('input','no_purchase','nominal','up'));
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
