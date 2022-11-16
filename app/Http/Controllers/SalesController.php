<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sales;
use DateTime;
class SalesController extends Controller
{
   public function data_sales(){
    $sales = Sales::all();
        $date = new DateTime();
        $ldate = date('Y-m-d');
        $code_sales = "SAL";
        $req = Sales::select('code_sales')->orderby('created_at','desc')->first();

        if($req != null){
            $bulan = $date->format('m');
            $bulanreq = substr($req->no_req,6,2);
            if($bulan == $bulanreq){
                $pcod = substr($req->no_req,13);
                $codplus = (int)$pcod + 1;
                $codigit = sprintf("%03s",$codplus);
                $kode = $code_sales.$date->format('dHis');
            }else{
                $kode = $code_sales.$date->format('dHis');
            }
        }else{
            $kode = $code_sales.$date->format('dHis');
        }
        return view('sales.index',compact('sales','kode'));

   }

   public function input_sales(Request $request){
    
    $input  = new Sales();
    $input->code_sales = $request->code_sales;
    $input->id_card    = $request->id_card;
    $input->nama_sales = $request->nama_sales;
    $input->no_hp      = $request->no_hp;
    $input->alamat     = $request->alamat;
    // $input->ktp        = $request->ktp;
    if ($request->hasFile('ktp')) {
        $file   = $request->file('ktp');
        $date   = new DateTime();
        $dpakai = $date->format('dmY');
        $name   = 'REQ'.$dpakai . time().'.'.$file->getClientOriginalExtension();
        $destinationPath = public_path('/imgreq/'.$name);
        //$file->move($destinationPath, $name);
        $img = Image::make($file)->resize(150, 200, function($constraint) {
        $constraint->aspectRatio();
        });
        $img->save($destinationPath);
        $input->ktp = $name;
    }
    
    else{
        $input->ktp = $request->ktp;
    }
    $input->save();

    return back()->with('pesan','berhasil');
   }
}
