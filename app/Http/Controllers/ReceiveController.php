<?php

namespace App\Http\Controllers;

use App\BahanbakuModel;
use Illuminate\Http\Request;
use App\BarangMasukModel;
use App\BayarsupplierModel;
use App\InvoiceBarangMasukModel;
use App\Master;
use App\SatuanModel;
use App\Receive;
use App\DetailReceive;
use DateTime;
use App\CabangModel;
use App\ReceivedModel;
use App\SupplierModel;
use App\GudangModel;
use App\BarangGudang;
use App\ReturnsupplierModel;
use App\InvoicereturnsupplierModel;
use App\SatuanBarangModel;
use DB;
use Illuminate\Support\Facades\Auth;
class ReceiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $date = new DateTime();
        // $date_plus = $date->modify("-3 days");
        // $dater = $date_plus->format("Y-m-d");
        // dd($dater);
        $user = Auth::user()->id;
        $receive = Receive::join('supplier_models','receives.id_supplier','supplier_models.id')
        ->select('receives.id',
                    'receives.no_receive',
                    // 'detail_receives.no_receive',
                    'receives.no_invoices',
                    'receives.tanggal_terima',
                    'receives.tanggal_invoice',
                    'supplier_models.nama_supplier',
                    'receives.due_date',
                    // 'receives.sub_total',
                    'receives.ppn',
                    'receives.big_totals',
                    'receives.terbayar',
                    'receives.sisa')
                    ->orderBy('receives.id','desc')
                    ->get();
                    $sum1 = Receive::sum('big_totals');
                    $sum2 = BayarsupplierModel::sum('nominal');
                    $sum3 = Receive::sum('sisa');
        return view('receive.index',compact('receive','sum1','sum2','sum3','user'));
    }

    public function inputbayar(Request $request,$id){
        $find = Receive::find($id);
        $no = $find->no_receive;
        $dp = $find->terbayar;
        $sisa = $find->sisa;
        // dd($sisa);
        return view('bayar.receivebayar',compact('find','no','dp','sisa'));
    }

    public function inputbayarbarangmasuk(Request $request){
        $input = new BayarsupplierModel();
        $input->no_receive = $request->no_receive;
        $input->nominal = $request->nominal;
        $input->save();
        $no_received = $request->no_receive;
        $nominal = $request->nominal;

        $up = Receive::where('no_receive',$no_received)->update([
            'terbayar'=> DB::raw("terbayar + $nominal"),'sisa' => DB::raw("sisa - $nominal")
        ]);
        // dd($no_purch);
        return back()->with('success', 'Record Created Successfully.');
    }
    public function detailbayar($id){
        $purc = Receive::find($id);
        $no = $purc->no_receive;
        // dd($no);
        // $tampil = PurchaseModel::where('no_purchase','er')->get();
    
    
        $tampil = BayarsupplierModel::where('no_receive',$no)->get();        
        $tot = Receive::where('no_receive',$no)->get();
        return view('receive.detailbayar',compact('purc','no','tampil','tot'));
    }
    public function detailbarangmasuk($id)
    {
        $purc = Receive::find($id);
        $no = $purc->no_receive;
        $tax = $purc->tax;
        // $tampil = PurchaseModel::where('no_purchase','er')->get();
    
    
        $tampil = DetailReceive::join('satuan_models','detail_receives.id_satuan','satuan_models.id')
        ->join('masters','detail_receives.id_barang','masters.id')

        ->select('detail_receives.id',
                    'detail_receives.no_receive',
                    'detail_receives.no_invoices',
                    'masters.nama_barang',
                    'satuan_models.nama_satuan',
                    'detail_receives.quantity',
                    'detail_receives.unit_price',
                    'detail_receives.total_price',
                    'detail_receives.status')
        ->where('detail_receives.no_receive',$no)
        ->get();
        $tot = Receive::where('no_receive',$no)->get();
        $sum = DetailReceive::where('detail_receives.no_receive',$no)->sum('total_price');
        // dd($sum);
        // dd($no);
        return view('receive.detail',compact('purc','tampil','no','sum','tot','tax'));
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $satuan = SatuanModel::all();
        $date = new DateTime();
        $supplier = SupplierModel::all();
        $big = Auth::user()->cabang_id;
        $gudang = Master::join('satuan_models','masters.id_satuan','satuan_models.id')
        ->where('id_cabang',$big)
        ->select('masters.id',
                'masters.code_master',
                'masters.nama_barang',
                'satuan_models.nama_satuan')
        ->get();
        $ldate = date('Y-m-d');
        $cabang1 = "REC";
        $cabang = CabangModel::all();
        $req = Receive::select('no_receive')->orderby('created_at','desc')->first();

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

       
        return view('receive/create',compact('gudang','cabang1','cabang','kode','date','req','satuan','ldate','supplier'));
    }
    public function datareturnsupplier(){
        $return = InvoicereturnsupplierModel::join('supplier_models','invoicereturnsupplier_models.id_supplier','supplier_models.id')
        ->where('invoicereturnsupplier_models.status_return',"=","Badstok")
        ->select('invoicereturnsupplier_models.id',
                    'invoicereturnsupplier_models.no_return',
                    'invoicereturnsupplier_models.no_invoice',
                    'invoicereturnsupplier_models.tgl_return',
                    'invoicereturnsupplier_models.tgl_invoice',
                    'supplier_models.nama_supplier',
                    'invoicereturnsupplier_models.sub_total',
                    'invoicereturnsupplier_models.tax',
                    'invoicereturnsupplier_models.big_total',
                    'invoicereturnsupplier_models.status_return')
                    ->orderBy('invoicereturnsupplier_models.id','desc')
                    ->get();
                    // dd($return);
        return view('receive/return',compact('return'));
    }

    public function datareturnsupplier2(){
        $return = InvoicereturnsupplierModel::join('supplier_models','invoicereturnsupplier_models.id_supplier','supplier_models.id')
        ->where('invoicereturnsupplier_models.status_return',"=","Goodstok")
        ->select('invoicereturnsupplier_models.id',
                    'invoicereturnsupplier_models.no_return',
                    'invoicereturnsupplier_models.no_invoice',
                    'invoicereturnsupplier_models.tgl_return',
                    'invoicereturnsupplier_models.tgl_invoice',
                    'supplier_models.nama_supplier',
                    'invoicereturnsupplier_models.sub_total',
                    'invoicereturnsupplier_models.tax',
                    'invoicereturnsupplier_models.big_total',
                    'invoicereturnsupplier_models.status_return')
                    ->orderBy('invoicereturnsupplier_models.id','desc')
                    ->get();
                    // dd($return);
        return view('receive/return',compact('return'));
    }

    
    public function detailreturn($id)
    {
        $inv = InvoicereturnsupplierModel::find($id);
        $no = $inv->no_return;
        $big = $inv->big_total;
        $tax = $inv->tax;
    
        $tampil = ReturnsupplierModel::join('masters','returnsupplier_models.id_barang','masters.id')
        ->join('satuan_models','returnsupplier_models.id_satuan','satuan_models.id')
        ->where('returnsupplier_models.no_return',$no)
        ->select('returnsupplier_models.id',
        'returnsupplier_models.no_return',
        'returnsupplier_models.no_invoices',
        'masters.nama_barang',
        'returnsupplier_models.berat',
        'satuan_models.nama_satuan',
        'returnsupplier_models.unit_price',
        'returnsupplier_models.quantity',
        'returnsupplier_models.total_price',
        'returnsupplier_models.status',
        'returnsupplier_models.status_return'
        )
        ->orderBy('returnsupplier_models.id','desc')
        ->get();
        // dd($pu);
        return view('receive/detailreturn',compact('inv','no','tampil','big','tax'));
    }

    public function returnsupplier(Request $request)
    {
        $satuan = SatuanModel::all();
        $date = new DateTime();
        $supplier = SupplierModel::all();
        $user = Auth::user()->cabang_id;
        $bahanbaku = Master::join('satuan_models','masters.id_satuan','satuan_models.id')
        ->where('id_cabang',$user)
        ->select('masters.id',
        'masters.nama_barang',
        'satuan_models.nama_satuan')
        ->get();
        $ldate = date('Y-m-d');
        $cabang1 = "RET";
        $cabang = CabangModel::all();
        $req = Receive::select('no_receive')->orderby('created_at','desc')->first();

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

       
        return view('receive/inputreturn',compact('bahanbaku','cabang1','cabang','kode','date','req','satuan','ldate','supplier','user'));
    }

    public function inputreturn(Request $request)
    {
        
        $no_return = $request->no_return;
        $tgl_return = $request->tgl_return;
        $no_invoice = $request->no_invoices;
        $tgl_invoice = $request->tgl_invoice;
        $id_supplier = $request->id_supplier;
        $sub_total = $request->sub_total;
        $tax = $request->tax;
        $big_total = $request->big_total;
        $status = "Return";
        $status_return = $request->status_return;

        foreach($request->id_barang as $key => $value)
        {
            $bahasa = new ReturnsupplierModel(); 
            $bahasa->no_return = $no_return;
            $bahasa->no_invoices = $no_invoice;   
            $bahasa->id_barang = $value;
            $cab = Auth::user()->cabang_id;
            $berat = Master::where('id',$value)->where('id_cabang',$cab)->get();
            // dd($berat);
            foreach($berat as $berad){
                
                $code_masters = $berad->code_master;
                $bb = $berad->berat;
                $stok = $berad->stok;
                $harga  = $berad->harga_pokok;
                $bahasa->berat = $bb;
           
            
            $bahasa->id_satuan = $request->id_satuan[$key];
            $bahasa->quantity = $request->quantity[$key];
            $kurangs = $request->quantity[$key];
            $bahasa->unit_price = $request->unit_price[$key];
            $bahasa->total_price = $request->total_price[$key];
            $bahasa->status = $status;
            $bahasa->status_return = $status_return;
            $bahasa->save();
            
            $kurangi = Master::where('id',$value)->update(['stok'=> DB::raw("stok - $kurangs")]);
            $yuks = Master::where('id',$value)->get();
            foreach($yuks as $yukss){
                $stokes = $yukss->stok;
             $update_stok = Master::where('code_master',$code_masters)
            ->where('berat','>',$bb)
            ->update(['stok'=> DB::raw("(berat/$bb) * $stokes"),'sub_total_pokok'=> DB::raw("stok * harga_pokok"),'sub_total_jual'=> DB::raw("stok * harga_jual")]);
            $updat_stok  = Master::where('code_master',$code_masters)
            ->where('berat','<',$bb)
            ->update(['stok'=> DB::raw("($stokes/$bb)* berat"),'sub_total_pokok'=> DB::raw("stok * harga_pokok"),'sub_total_jual'=> DB::raw("stok * harga_jual")]);
            }
            }
           
        }


        InvoicereturnsupplierModel::create([
                'no_return' => $no_return,
                'no_invoice' => $no_invoice,
                'tgl_invoice' => $tgl_invoice,
                'tgl_return' => $tgl_return,
                'id_supplier' => $id_supplier,
                'sub_total' => $sub_total,
                'tax' => $tax,
                'big_total' => $big_total,
                'status_return' => $status_return

            ]);

       

        
        return back()->with('success', 'Record Created Successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $no_receive = $request->no_receive;
        $tgl_terima = $request->tanggal_terima;
        $no_invoice = $request->no_invoices;
        $tgl_invoice = $request->tgl_invoice;
        $id_supplier = $request->id_supplier;
        $due_date   = $request->due_date;
        $sub_total = $request->sub_total;
        $tax = $request->tax;
        $big_total = $request->big_total;
        $dp = $request->dp;
        $sisa = $request->sisa;
        $status = "Auto Instok";
        // dd($big_total);
        foreach($request->id_barang as $key => $value)
        {
            $bahasa = new DetailReceive(); 
            $bahasa->no_receive = $no_receive;
            $bahasa->no_invoices = $no_invoice;
            $bahasa->id_barang = $value;
            // $bahasa->berat = $request->berat[$key];
            $ws = Master::where('id',$value)->get();
            // dd($ws);
            foreach($ws as $w){
                $idsat = $w->id_satuan;
                $harga_pokok =$w->harga_pokok;
            }
            $bahasa->id_satuan = $idsat;
            $bahasa->quantity = $request->quantity[$key];
            $qty = $request->quantity[$key];
            $bahasa->unit_price = $request->unit_price[$key];
            $harga_new =$request->unit_price[$key];
            $bahasa->total_price = $request->total_price[$key];
            $bahasa->status = $status;
            // $bahasa->id_cabang = Auth::user()->cabang_id;
            $bahasa->save();
            $update_ = Master::where('id',$value)->update(['stok' => DB::raw("stok + $qty"),'sub_total_pokok'=> DB::raw("stok * harga_pokok"),'sub_total_jual'=> DB::raw("stok * harga_jual")]);
            $get_masters = Master::where('id',$value)->select('code_master','berat','stok','harga_pokok')->get();
            foreach($get_masters as $get_mas){
                $code_masters = $get_mas->code_master;
                $berats = $get_mas->berat;
                $stok = $get_mas->stok;
                $harga  = $get_mas->harga_pokok;
            }
            // dd($harga);
            if($harga_new > $harga){
                $update_harga = Master::where('id',$value)->update(['harga_pokok' => DB::raw("$harga_new"),'harga_jual' => DB::raw("$harga_new + margin")]);
                $update_harga2 = Master::where('code_master',$code_masters)
                                        ->where('berat','>',$berats)
                                        ->update(['harga_pokok' => DB::raw("$harga_new/(berat/$berats)"),'harga_jual' => DB::raw("harga_pokok + margin")]);
                $update_hargas = Master::where('code_master',$code_masters)
                                        ->where('berat','<',$berats)
                                        ->update(['harga_pokok' => DB::raw("$harga_new*($berats/berat)"),'harga_jual' => DB::raw("harga_pokok + margin")]);
                                        
            }else{
            
            }
            // $update_stok = Master::where('code_master',$code_masters)
            // ->where('berat','=',$berats)
            // ->update(['stok' => DB::raw("stok + $qty"),'sub_total_pokok'=> DB::raw("stok * harga_pokok"),'sub_total_jual'=> DB::raw("stok * harga_jual")]);
            $update_stok = Master::where('code_master',$code_masters)
            ->where('berat','>',$berats)
            ->update(['stok'=> DB::raw("(berat/$berats) * $stok"),'sub_total_pokok'=> DB::raw("stok * harga_pokok"),'sub_total_jual'=> DB::raw("stok * harga_jual")]);
            $updat_stok  = Master::where('code_master',$code_masters)
            ->where('berat','<',$berats)
            ->update(['stok'=> DB::raw("($stok/$berats)* berat"),'sub_total_pokok'=> DB::raw("stok * harga_pokok"),'sub_total_jual'=> DB::raw("stok * harga_jual")]);

            
            
        }
        // dd($sub_total);
        Receive::create([
            'no_receive' => $no_receive,
            'no_invoices' => $no_invoice,
            'tanggal_invoice' => $tgl_invoice,
            'tanggal_terima' => $tgl_terima,
            'id_supplier' => $id_supplier,
            'due_date' => $due_date,
            'big_total' => $sub_total,
            'ppn' => $tax,
            'big_totals' => $big_total,
            'terbayar' => $dp,
            'sisa' => $sisa,
            'cabang_id' => Auth::user()->cabang_id,
            'keterangan' =>  "Siap"


        ]);
    
    
    $input = new BayarsupplierModel();
    $input->no_receive = $no_receive;
    $input->nominal = $dp;
    $input->save();
      
       
        return back()->with('success', 'Record Created Successfully.');
    }

    public function instok($id){
        $tampil = ReceivedModel::find($id);
        $no = $tampil->id_barang;
        $qty = $tampil->quantity;
        $harga = $tampil->unit_price;
        $id_barang = $tampil->id_barang;
        $tampil->update(['status' => "in stok"]);
        $bahanbaku = BahanbakuModel::where('id',$id_barang)->update(['harga_pk'=>$harga]);
        $bahanb = BahanbakuModel::all();
        foreach($bahanb as $bah){
            $pk = $bah->harga_pk;
            $up = $bah->harga_up;
        }
        $gudang = GudangModel::where('id_bahanbaku',$id_barang)->update(['harga_pk'=>$harga,'margin'=> ($harga*($up/100)),'stok'=> DB::raw("stok + $qty"),'sub_totalpk'=> DB::raw("$harga * stok"),'sub_total'=> DB::raw("($harga*($up/100))*stok")]);
        // $ubah = GudangModel::where('id_bahanbaku',$no)->update(['stok'=> DB::raw("stok + $qty"),'sub_total'=> ($harga*($up/100)) * $qty]);
        
        // dd($up);
        return redirect()->back();
    }
    public function print($id){
        $purc = Receive::find($id);
        $no = $purc->no_receive;
        // $tampil = PurchaseModel::where('no_purchase','er')->get();
        $supplier = Receive::join('supplier_models','receives.id_supplier','supplier_models.id')
                                        ->where('no_receive',$no)
                                        ->select('supplier_models.nama_supplier',
                                        'supplier_models.no_hp',
                                        'supplier_models.alamat',
                                        'receives.due_date',
                                        'receives.big_totals',
                                        'receives.big_total',
                                        'receives.terbayar',
                                        'receives.ppn',
                                        'receives.sisa',
                                        'receives.no_invoices',
                                        'receives.tanggal_invoice',
                                        'receives.tanggal_terima')
                                        ->get();
        $bayar = BayarsupplierModel::where('no_receive',$no)->sum('nominal'); 
    
        $tampil = DetailReceive::join('satuan_models','detail_receives.id_satuan','satuan_models.id')
       ->join('masters','detail_receives.id_barang','masters.id')
        ->select('detail_receives.id',
                    'detail_receives.no_receive',
                    'detail_receives.no_invoices',
                    'masters.nama_barang',
                    // 'detail_receives.berat',
                    'satuan_models.nama_satuan',
                    'detail_receives.quantity',
                    'detail_receives.unit_price',
                    'detail_receives.total_price',
                    'detail_receives.status')
        ->where('detail_receives.no_receive',$no)
        ->get();
        $tot = Receive::where('no_receive',$no)->get();
        $sum = DetailReceive::where('detail_receives.no_receive',$no)->sum('total_price');
        // dd($tampil);
        // dd($no);
        return view('receive.print',compact('purc','tampil','no','sum','tot','supplier','bayar'));
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
