<?php

namespace App\Http\Controllers;
use App\Master;
use DateTime;
use App\CabangModel;
use App\SatuanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cabang_id = Auth::user()->cabang_id;

        $master = Master::join('satuan_models','masters.id_satuan','satuan_models.id')
        ->where('id_cabang',$cabang_id)
        ->select('masters.id',
                'masters.code_master',
                'masters.nama_barang',
                'masters.berat',
                'satuan_models.nama_satuan',
                'masters.harga_pokok',
                'masters.margin',
                'masters.harga_jual',
                'masters.stok',
                'masters.sub_total_pokok',
                'masters.sub_total_jual',
                'masters.id_cabang')
                ->orderBy('masters.id','desc')
                ->get();
        // dd($master);        
        return view('warehouse/indexmaster',compact('cabang_id','master'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $satuan = SatuanModel::all();
        $akses = Auth::user()->id_akses;
        // dd($akses);
        $date = new DateTime();
        $req = Master::select('code_master')->orderby('created_at','desc')->first();

        if($req != null){
            $bulan = $date->format('m');
            $bulanreq = substr($req->code_master,6,2);
            if($bulan == $bulanreq){
                $pcod = substr($req->code_master,13);
                $codplus = (int)$pcod + 1;
                $codigit = sprintf("%05s",$codplus);
                $kode = 'BRG'.$date->format('His').$codigit;
            }else{
                $kode = 'BRG'.$date->format('His').'0001';
            }
        }else{
            $kode = 'BRG'.$date->format('His').'0001';
        }
        return view('warehouse/createmaster',compact('satuan','akses','kode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cabang_id = Auth::user()->cabang_id;
        $akses = Auth::user()->hak_akses;
        $namabarang = $request->nama_barang;
        $harga_pokok = $request->harga_pokok;
        $margin = $request->margin;
        $code_master = $request->code_master;
        $stok = "0";
        // $bahanbaku = BahanbakuModel::where('id',$id)->get();
        // $harga_pk = $bahanbaku->harga_pk;
        // $harga_up = $bahanbaku->harga_up;
        // $harga_new = ($harga_pk * ($harga_up/100));

        $request->validate([
            // 'addmore.*.code_master' => $code_master,
            // 'addmore.*.nama_barang' => $namabarang,
            'addmore.*.berat',
            'addmore.*.id_satuan',
            'addmore.*.harga_pokok',
            'addmore.*.margin',
            'addmore.*.harga_jual',
            'addmore.*.stok' ,
            'addmore.*.sub_total_pokok',
            'addmore.*.sub_total_jual',
            // 'addmore.*.id_cabang' => $cabang_id
            
        ]);
    
        foreach ($request->addmore as $key => $value) {
                $insert = Master::create([
                    'code_master' => $code_master,
                    'nama_barang' => $namabarang,
                    'berat' => $value['berat'],
                    'id_satuan' => $value['id_satuan'],
                    'harga_pokok' => $value['harga_pokok'],
                    'margin' => $value['margin'],
                    'harga_jual' => $value['harga_pokok'] + $value['margin'],
                    'stok' => $value['berat'],
                    $jual = $value['harga_pokok'] + $value['margin'],
                    'sub_total_pokok' => $value['harga_pokok'] * $value['berat'],
                    'sub_total_jual'=> $jual * $value['berat'],
                    'id_cabang' => $cabang_id,
    
                ]);
            }
            // dd($insert);
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
