<?php

namespace App\Http\Controllers;

use App\JenisPengeluaranModel;
use App\PengeluaranGudangModel;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Auth;
class PengeluaranGudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cabang = Auth::user()->hak_akses;
        $tampil = PengeluaranGudangModel::join('users','pengeluaran_gudang_models.id_user','users.id')
            ->join('jenis_pengeluaran_models','pengeluaran_gudang_models.id_guna','jenis_pengeluaran_models.id')
            ->where('pengeluaran_gudang_models.hak_akses',$cabang)
            ->select('pengeluaran_gudang_models.id',
            'pengeluaran_gudang_models.no_pengeluaran',
            'jenis_pengeluaran_models.nama_pengeluaran',
            'pengeluaran_gudang_models.nama_barang',
            'pengeluaran_gudang_models.jumlah',
            'pengeluaran_gudang_models.nominal',
            'pengeluaran_gudang_models.total',
            'users.name',
            'pengeluaran_gudang_models.hak_akses',
            'pengeluaran_gudang_models.tanggal_pengeluaran')
            ->get();
            // dd($tampil);
        return  view('pengeluarangudang/index',compact('cabang','tampil'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ldate = date('Y-m-d');
        $date = new DateTime();
        $cabang1 = "PEN";
        $jenis = JenisPengeluaranModel::all();
        $req = PengeluaranGudangModel::select('no_pengeluaran')->orderby('tanggal_pengeluaran','desc')->first();

        if($req != null){
            $bulan = $date->format('m');
            $bulanreq = substr($req->no_req,6,2);
            if($bulan == $bulanreq){
                $pcod = substr($req->no_req,13);
                $codplus = (int)$pcod + 1;
                $codigit = sprintf("%03s",$codplus);
                $kode = $cabang1.'-'.$date->format('d/His');
            }else{
                $kode = $cabang1.'-'.$date->format('d/His');
            }
        }else{
            $kode = $cabang1.'-'.$date->format('d/His');
        }
        return view('pengeluarangudang/create',compact('ldate','date','req','cabang1','kode','jenis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cek_Data1 = $request->no_pengeluaran;
        $cek_Data4 = $request->total;
        $cek_Data2 = Auth::user()->id;
        $cek_Data3 = Auth::user()->hak_akses;
        $tanggal = date('Y-m-d');
    
    
        foreach ($request->id_guna as $key => $value) {
            $input = new PengeluaranGudangModel();
            $input->hak_akses =  $cek_Data3;
            $input->id_user = $cek_Data2;
            $input->no_pengeluaran = $cek_Data1;
            $input->id_guna = $request->id_guna[$key];
            $input->nama_barang = $request->nama_barang[$key];
            $input->tanggal_pengeluaran = $request->tanggal_pengeluaran;
            $input->jumlah = $request->jumlah[$key];
            $input->nominal = $request->nominal[$key];
            $input->total_price = $request->total_price[$key];
            $input->total = $cek_Data4;
            $input->save();
            
           
        }
        // dd($request->addmore);
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
