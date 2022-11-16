<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RequestModel;
use App\User;
use App\CabangModel;
use App\AkibatModel;
use App\PenyebabModel;
use Mail;
use App\Exports\Requestall;
use App\Exports\Requestsolved;
use App\Exports\Requestclose;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
class HelpdeskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $request = RequestModel::orderby('id','desc')->get();

        return view('helpdesk/index',compact('request'));
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
        return RequestModel::find($id) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function view($id)
    // {
    //         $request = RequestModel::find($id);
    //         $cabang = CabangModel::all();
    //         $akibat = AkibatModel::all();
    //         $penyebab = PenyebabModel::all();

    //         return view('helpdesk.view',compact('request','cabang','akibat','penyebab'));

    // }

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
        $req->update([
            'status' => "solved",
            'tgl_solved' => now(),
            'aktor'=> Auth::user()->name,
            'metode'    => $request->solved
        ]);

        $user =  User::where('name',$req->pelapor)->first();
        // Mail::send('emailtouser',['no_req' => $req->no_req,'user' => $req->pelapor,'permintaan' => $req->permintaan ], function($message) use ($user){
        //     $message->to($user->email,'To '.$user['name'])->subject('Approval Request Note');
        //     $message->from('mekahelpdesk1@gmail.com','Helpdesk Meka');
        // });
        return redirect(route('helpdesk.index'))->with('pesan','berhasil di solved');


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

    public function exportall()
    {
        return Excel::download(new Requestall, 'Request Note.xlsx');
    }

    public function exportsolved()
    {
        return Excel::download(new Requestsolved, 'Request Note Solved.xlsx');
    }

    public function exportclose()
    {
        return Excel::download(new Requestclose, 'Request Note Closed.xlsx');
    }

    public function solved(Request $request, $id)
    {
        $req = RequestModel::find($id);
        $req->update([
            'status' => "solved",
            'tgl_solved' => now(),
            'aktor'=> Auth::user()->name,
            'metode'    => $request->solved
        ]);

        $user =  User::where('name',$req->pelapor)->first();
        // Mail::send('emailtouser',['no_req' => $req->no_req,'user' => $req->pelapor,'permintaan' => $req->permintaan ], function($message) use ($user){
        //     $message->to($user->email,'To '.$user['name'])->subject('Approval Request Note');
        //     $message->from('mekahelpdesk1@gmail.com','Helpdesk Meka');
        // });
        return redirect(route('helpdesk.index'))->with('pesan','berhasil di solved');

    }

    public function rejected(Request $request,$id)
    {
        $req = RequestModel::find($id);
        $req->update([
            'status' => "rejected",
            'tgl_rejected' => now(),
            'rejectchiefstore'=>Auth::user()->name,
            'reasonreject' => $request ->solved
        ]);
       // dd($req);

        $user =  User::where('name',$req->pelapor)->first();
        // Mail::send('emailtorejectuser',['user' => $req->pelapor,'no_req' => $req->no_req,'permintaan' => $req->permintaan ], function($message) use ($user){
        //     $message->to($user->email,'To '.$user['name'])->subject('Approval Request Note');
        //     $message->from('mekahelpdesk1@gmail.com','Helpdesk Meka');
        // });
        return redirect(route('helpdesk.index'))->with('pesan','telah di reject');
    }

    public function forward($id)
    {
        $req = RequestModel::find($id);
        $req->update(['status' => "waiting infra"]);
        return redirect(route('helpdesk.index'))->with('pesan','telah di forward ke Infra');
    }

    public function forwardrnd($id)
    {
        $req = RequestModel::find($id);
        $req->update(['status' => "waiting rnd"]);
        return redirect(route('helpdesk.index'))->with('pesan','telah di forward ke Rnd');
    }
    //update 06012020 pe
    public function forwardfinance($id)
    {
        $req = RequestModel::find($id);
        $req->update(['status' => "waiting finance"]);
        return redirect(route('helpdesk.index'))->with('pesan','telah di forward ke Finance');
    }
    public function forwardsupplychain($id)
    {
        $req = RequestModel::find($id);
        $req->update(['status' => "waiting supplychain"]);
        return redirect(route('helpdesk.index'))->with('pesan','telah di forward ke supplychain');
    }
    public function proseshelpdesk(Request $request ,$id)
    {
        $req = RequestModel::find($id);
        $req->update(['status' => "proses helpdesk",
        'proseshelp'=> Auth::user()->name
        ]);
        return redirect(route('helpdesk.index'))->with('pesan','telah di Proses Helpdesk');
    }
    public function unproseshelpdesk($id)
    {
        $req = RequestModel::find($id);
        $req->update(['status' => "approved"]);
        return redirect(route('helpdesk.index'))->with('pesan','telah di batalkan');
    }

    public function print($id){
        $req = RequestModel::find($id);
        $user = User::where('name',$req->pelapor)->first();
        $chiefs = User::where('name',$req->chiefstore)->first();
        return view('helpdesk.printreq',compact('req','user','chiefs'));
    }

    public function getpercabang(){
        return RequestModel::groupBy('cabang_id')
        ->selectRaw('count(*) as total, cabang_id')
        ->with('cabang')
        ->get()->toJson();
    }
    public function open(){
        $cabang = Auth::user()->cabang_id;
        $request = RequestModel::where([ 'status' => 'open'])->get();
        return view('helpdesk/index',compact('request'));
    }
    public function approveshow(){
        $cabang = Auth::user()->cabang_id;
        $request = RequestModel::where([ 'status' => 'approved'])->get();
        return view('helpdesk/index',compact('request'));
    }
    public function rejectedshow(){
        $cabang = Auth::user()->cabang_id;
        $request = RequestModel::where([ 'status' => 'rejected'])->get();
        return view('helpdesk/index',compact('request'));
    }
    public function close(){
        $cabang = Auth::user()->cabang_id;
        $request = RequestModel::where([ 'status' => 'close'])->get();
        return view('helpdesk/index',compact('request'));
    }

}
