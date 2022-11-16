<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RequestModel;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Mail;
use Image;
use App\User;
use App\PenyebabModel;
use App\AkibatModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pelapor = Auth::user()->name;
        $request = RequestModel::where('pelapor',$pelapor)->orderby('id','desc')->with('rel_penyebab','rel_akibat')->get();
        return view('user/index',compact('request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $akibat   = AkibatModel::all();
        // $penyebab     = PenyebabModel::all();
        $date = new DateTime();
        $req = RequestModel::select('no_req')->orderby('created_at','desc')->first();

        if($req != null){
            $bulan = $date->format('m');
            $bulanreq = substr($req->no_req,6,2);
            if($bulan == $bulanreq){
                $pcod = substr($req->no_req,13);
                $codplus = (int)$pcod + 1;
                $codigit = sprintf("%05s",$codplus);
                $kode = 'REQ/'.$date->format('dmY').'/'.$codigit;
            }else{
                $kode = 'REQ/'.$date->format('dmY').'/00001';
            }
        }else{
            $kode = 'REQ/'.$date->format('dmY').'/00001';
        }
        //dd($kode);
        return view('user/create',compact('penyebab','akibat','kode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestmodel = new Requestmodel();
        $requestmodel->pelapor = $request->pelapor;
        $requestmodel->cabang_id = $request->cabang_id;
        $requestmodel->status = $request->status;
        $requestmodel->aktor = $request->aktor;
        $requestmodel->proseshelp = $request->proseshelp;
        $requestmodel->chiefstore = $request->chiefstore;
        $requestmodel->rejectchiefstore = $request->rejectchiefstore;
        $requestmodel->tgl_approved = $request->tgl_approved;
        $requestmodel->tgl_rejected = $request->tgl_rejected;
        $requestmodel->tgl_solved = $request->tgl_solved;
        $requestmodel->tgl_close = $request->tgl_close;
        $requestmodel->no_req = $request->no_req;
        $requestmodel->spk = $request->spk;
        $requestmodel->permintaan = $request->permintaan;
        $requestmodel->penyebab = $request->penyebab;
        $requestmodel->dll_penyebab = $request->dll_penyebab;
        $requestmodel->akibat = $request->akibat;
        $requestmodel->dll_akibat = $request->dll_akibat;
        $requestmodel->permintaan = $request->permintaan;
        $requestmodel->penyebab = $request->penyebab;
        
        if ($request->hasFile('lampiran')) {
            $file   = $request->file('lampiran');
            $date   = new DateTime();
            $dpakai = $date->format('dmY');
            $name   = 'REQ'.$dpakai . time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('/imgreq/'.$name);
            //$file->move($destinationPath, $name);
            $img = Image::make($file)->resize(150, 200, function($constraint) {
            $constraint->aspectRatio();
            });
            $img->save($destinationPath);
            $requestmodel->lampiran = $name;
        }
        
        else{
            $requestmodel->lampiran = $request->lampiran;
        }

        $requestmodel->save();
        // RequestModel::create($request->all());
        // $cabang_id = Auth::user()->cabang_id;
        // $requestnote = RequestModel::where('pelapor',Auth::user()->name)->first();
        // $chiefstore = User::where(['hak_akses' => 'Chiefstore', 'cabang_id' => $cabang_id])->first();

        // request()->validate(['lampiran' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);
        // $imageName = time().'.'.request()->image->getClientOriginalExtension();
        // request()->image->move(public_path('lampiran'), $imageName);
        // if($chiefstore != null){
        //     Mail::send('emailtochiefstore',['user' => Auth::user()->name,'no_req' => $requestnote->no_req,'permintaan' => $requestnote->permintaan ], function($message) use ($chiefstore){
        //         $message->to($chiefstore->email,'To '.$chiefstore['name'])->subject('Approval Request Note');
        //         $message->from('mekahelpdesk1@gmail.com','Helpdesk Meka');
        //     });
       // }
        return redirect(route('user.index'))->with('pesan','berhasil');
    }

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
        $akibat   = AkibatModel::all();
        $penyebab  = PenyebabModel::all();
       $request = RequestModel::find($id);
       return view('user.edit',compact('request','akibat','penyebab'));
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
        if($request->status == 'rejected'){
            $request['status'] = 'open';
        }
        $req->update($request->all());
        return redirect(route('user.index'))->with('pesan','berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RequestModel::find($id)->delete();
        return back()->with('pesan','berhasil');
    }
    public function close($id)
    {
        $now = new DateTime();
        $timestamp = $now->format('y-m-d H:i:s');
        $req = RequestModel::find($id);
        $req->update(['status' => "close",'tgl_close' => $timestamp]);
        return redirect(route('user.index'))->with('pesan','berhasil di close');
    }

}
