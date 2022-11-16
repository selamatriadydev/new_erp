<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RequestModel;
use Auth;
class RndController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = RequestModel::where('status','waiting rnd')->orWhere('status','proses rnd')
        ->orderby('id','desc')->get();
        return view('infra/index',compact('request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $req = RequestModel::find($id);
        $req->update(
            ['status' => "solved",'tgl_solved' => now(),
            'aktor'=> Auth::user()->name,
            'metode'    => $request->solved]);
        return redirect(route('rnd.index'))->with('pesan','berhasil di solved');
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

    public function solved($id)
    {
        $req = RequestModel::find($id);
        $req->update(['status' => "solved",'tgl_solved' => now()]);
        return redirect(route('rnd.index'))->with('pesan','berhasil di solved');
    }

    public function rejected($id)
    {
        $req = RequestModel::find($id);
        $req->update(['status' => "approved",
        'tgl_rejected' => now(),
        'rejectchiefstore'=>Auth::user()->name,]);
        return redirect(route('rnd.index'))->with('pesan','telah di reject');
    }
    //update 06012020
    public function forwardfinance($id)
    {
        $req = RequestModel::find($id);
        $req->update(['status' => "waiting finance"]);
        return redirect(route('rnd.index'))->with('pesan','telah di forward ke Finance');
    }
    public function forwardsupplychain($id)
    {
        $req = RequestModel::find($id);
        $req->update(['status' => "waiting supplychain"]);
        return redirect(route('rnd.index'))->with('pesan','telah di forward ke supplychain');
    }
    public function prosesrnd(Request $request, $id)
    {
        $req = RequestModel::find($id);
        $req->update(['status' => "proses rnd",
        'prosesrnd'=> Auth::user()->name]);
        return redirect(route('rnd.index'))->with('pesan','telah di Proses rnd');
    }
    public function unprosesrnd($id)
    {
        $req = RequestModel::find($id);
        $req->update(['status' => "waiting rnd"]);
        return redirect(route('rnd.index'))->with('pesan','telah di batalkan');
    }
}
