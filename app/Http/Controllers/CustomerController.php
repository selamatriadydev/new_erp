<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provinces;
use App\Regencies;
use App\Villages;
use App\Districts;
use App\Customer;
use App\Sales;
use DateTime;
class CustomerController extends Controller
{
    public function data_customer(){
        $customerz = Customer::join('sales','customers.code_sales','sales.code_sales')
                            ->join('regencies','customers.id_kab','regencies.id')
                            ->join('districts','customers.id_kec','districts.id')
                            ->join('villages','customers.id_kel','villages.id')
                            ->select(
                                'customers.id',
                                'customers.code_customer',
                                'customers.no_ktp',
                                'customers.npwp',
                                'customers.nama',
                                'customers.toko',
                                'customers.no_hp',
                                'customers.alamat',
                                'sales.nama_sales',
                                'regencies.name as kab',
                                'districts.name as kec',
                                'villages.name as des'
                            )
                            ->get();
                            // dd($customerz);
        $sales = Sales::all();
        $provinces = Provinces::pluck('name', 'id');
        $reg = Regencies::where('id','=',"3325")->get();
        $dis = Districts::where('regency_id','=',"3325")->get();
        $from  = "33";
        $to   = "34";
        $vill = Villages::whereBetween('district_id', [$from, $to])->get();
        // dd($reg);
        // dd($bayar);
        $kabupaten = Regencies::whereBetween('province_id', [$from, $to])->get();

        $customer = Customer::all();
        $date = new DateTime();
        $ldate = date('Y-m-d');
        $code_cust = "CUST";
        $req = Customer::select('code_customer')->orderby('created_at','desc')->first();

        if($req != null){
            $bulan = $date->format('m');
            $bulanreq = substr($req->no_req,6,2);
            if($bulan == $bulanreq){
                $pcod = substr($req->no_req,13);
                $codplus = (int)$pcod + 1;
                $codigit = sprintf("%03s",$codplus);
                $kode = $code_cust.$date->format('dHis');
            }else{
                $kode = $code_cust.$date->format('dHis');
            }
        }else{
            $kode = $code_cust.$date->format('dHis');
        }

        return view('customer/index',compact('reg','dis','vill','kabupaten','kode','customer','customerz','sales'));
    }

   


    public function create_customer(){
        $provinces = Provinces::pluck('name', 'id');
        $reg = Regencies::where('id','=',"3325")->get();
        $dis = Districts::where('regency_id','=',"3325")->get();
        $from  = "33";
        $to   = "34";
        $vill = Villages::whereBetween('district_id', [$from, $to])->get();
        // dd($reg);
        // dd($bayar);
        $kabupaten = Regencies::whereBetween('province_id', [$from, $to])->get();;
        return view('customer/create',compact('reg','dis','vill','kabupaten'));
    }

    public function getKecamatan(Request $request){
        $kecamatan = Districts::where("regency_id",$request->kabID)->pluck('id','name');
        return response()->json($kecamatan);
    }
    public function getDesa(Request $request){
        $desa = Villages::where("district_id",$request->kecID)->pluck('id','name');
        return response()->json($desa);
    }

    public function input_cust(Request $request){
        $input                = new Customer();
        $input->code_customer = $request->code_customer;
        $input->no_ktp        = $request->no_ktp;
        $input->npwp          = $request->npwp;
        $input->nama          = $request->nama;
        $input->toko          = $request->toko;
        $input->no_hp         = $request->no_hp;
        $input->alamat        = $request->alamat;
        $input->code_sales    = $request->code_sales;
        $input->pict_ktp      = $request->pict_ktp;
        $input->id_kab        = $request->id_kab;
        $input->id_kec        = $request->id_kec;
        $input->id_kel        = $request->id_kel;
        $input->save();

        return back()->with('pesan','berhasil');

    }
}
