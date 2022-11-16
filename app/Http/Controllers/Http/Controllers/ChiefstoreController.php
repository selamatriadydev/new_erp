<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RequestModel;
use Auth;
use Mail;
use App\user;
class ChiefstoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cabang = Auth::user()->cabang_id;
        $request = RequestModel::where('cabang_id',$cabang)->orderby('id','desc')->get();
        return view('chiefstore/index',compact('request'));
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

    public function approve($id)
    {
        $req = RequestModel::find($id);
        $req->update(['status' => "approved",'tgl_approved' => now(),'chiefstore'=>Auth::user()->name]);
        $user =  User::where('name',$req->pelapor)->first();
        //email ke user
        // Mail::send('emailtouser',['user' => $req->pelapor,'no_req' => $req->no_req,'permintaan' => $req->permintaan ], function($message) use ($user){
        //     $message->to($user->email,'To '.$user['name'])->subject('Approval Request Note');
        //     $message->from('mekahelpdesk1@gmail.com','Helpdesk Meka');
        // });
        // //email ke pelapor
        // Mail::send('emailtohelpdesk',['user' => $req->pelapor,'no_req' => $req->no_req,'permintaan' => $req->permintaan ], function($message) use ($user){
        //     $message->to('mekahelpdesk1@gmail.com','To Helpdesk Meka')->subject('Approval Request Note');
        //     $message->from('mekahelpdesk1@gmail.com','Helpdesk Meka');
        // });



        return redirect(route('chiefstore.index'))->with('pesan','berhasil di approved');
    }

    public function rejected(Request $request,$id)
    {
        $req = RequestModel::find($id);

        $req->update(['status' => "rejected",
         'tgl_rejected' => now(),
        'rejectchiefstore'=>Auth::user()->name,
        'reasonreject' => $request ->solved]);
        //before update aktor
        //$req->update(['status' => "rejected"]);

        $user =  User::where('name',$req->pelapor)->first();
        //email ke user
        // Mail::send('emailtouseropen',['user' => $req->pelapor,'no_req' => $req->no_req,'permintaan' => $req->permintaan ], function($message) use ($user){
        //     $message->to($user->email,'To '.$user['name'])->subject('Rejected Request Note by chiefstore');
        //     $message->from('mekahelpdesk1@gmail.com','Helpdesk Meka');
        // });
        return redirect(route('chiefstore.index'))->with('pesan','telah di reject');
    }

    public function open(){
        $cabang = Auth::user()->cabang_id;
        $request = RequestModel::where(['cabang_id' => $cabang, 'status' => 'open'])->get();
        return view('chiefstore/index',compact('request'));
    }
    public function approveshow(){
        $cabang = Auth::user()->cabang_id;
        $request = RequestModel::where(['cabang_id' => $cabang, 'status' => 'approved'])->get();
        return view('chiefstore/index',compact('request'));
    }
    public function rejectedshow(){
        $cabang = Auth::user()->cabang_id;
        $request = RequestModel::where(['cabang_id' => $cabang, 'status' => 'rejected'])->get();
        return view('chiefstore/index',compact('request'));
    }
    public function close(){
        $cabang = Auth::user()->cabang_id;
        $request = RequestModel::where(['cabang_id' => $cabang, 'status' => 'close'])->get();
        return view('chiefstore/index',compact('request'));
    }

    public function getpercabang(){
        return RequestModel::groupBy('cabang_id')
        ->selectRaw('count(*) as total, cabang_id')
        ->with('cabang')
        ->get()->toJson();
    }

    public function chartpenyebab(){
        return RequestModel::groupBy('penyebab', 'dll_penyebab')
        ->selectRaw('count(*) as total, penyebab, dll_penyebab ')
        ->with('rel_penyebab')
        ->get()->toJson();
    }

    public function chartakibat(){
        return RequestModel::groupBy('akibat', 'dll_akibat')
        ->selectRaw('count(*) as total, akibat, dll_akibat')
        ->with('rel_akibat')
        ->get()->toJson();
    }
}
