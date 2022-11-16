<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RequestModel;
use Auth;
class SupplychainController extends Controller
{
    public function index()
    {
        $request = RequestModel::where('status','waiting supplychain')->orWhere('status','proses supplychain')
        ->orderby('id','desc')->get();
        return view('infra/index',compact('request'));
    }
    public function solved($id)
    {
        $req = RequestModel::find($id);
        $req->update(['status' => "solved",'tgl_solved' => now()]);
        return redirect(route('supplychain.index'))->with('pesan','berhasil di solved');
    }

    public function rejected($id)
    {
        $req = RequestModel::find($id);
        $req->update(['status' => "approved",
        'tgl_rejected' => now(),
        'rejectchiefstore'=>Auth::user()->name,]);
        return redirect(route('supplychain.index'))->with('pesan','telah di reject');
    }
    //update 06012020
    public function forwardrnd($id)
    {
        $req = RequestModel::find($id);
        $req->update(['status' => "waiting rnd"]);
        return redirect(route('supplychain.index'))->with('pesan','telah di forward ke rnd');
    }
   
    public function forwardhelpdesk($id)
    {
        $req = RequestModel::find($id);
        $req->update(['status' => "approve"]);
        return redirect(route('supplychain.index'))->with('pesan','telah di forward ke helpdesk');
    }
    public function prosessupply($id)
    {
        $req = RequestModel::find($id);
        $req->update(['status' => "proses supplychain"]);
        return redirect(route('supplychain.index'))->with('pesan','telah di Proses Supplychain');
    }
    public function unprosessupply($id)
    {
        $req = RequestModel::find($id);
        $req->update(['status' => "waiting supplychain"]);
        return redirect(route('supplychain.index'))->with('pesan','telah di batalkan');
    }

}
