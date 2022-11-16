<?php

namespace App\Http\Controllers;

use App\BayarHutangCabangModel;
use App\CabangModel;
use App\GudangCabangModel;
use App\InvoicePeminjamanModel;
use App\PeminjamanModel;
use App\BarangGudang;
use App\BarangGudangCabang;
use App\PiutangCabangModel;
use App\PurchaseModel;
use App\SatuanModel;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;

class GudangCabangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pilih = CabangModel::all();
        $cabang = Auth::user()->cabang_id;
        $hak_akses = Auth::user()->hak_akses;
        $gudangcabang = BarangGudangCabang::join('satuan_models','barang_gudang_cabangs.id_satuan','satuan_models.id')
        ->where('cabang_id',$cabang)
        ->where('nama_gudang',$hak_akses)
        ->select('barang_gudang_cabangs.id',
                  'barang_gudang_cabangs.code_barang_model',
                   'barang_gudang_cabangs.nama_barang',
                   'barang_gudang_cabangs.berat',
                   'satuan_models.nama_satuan',
                   'barang_gudang_cabangs.stok',
                   'barang_gudang_cabangs.harga_pokok',
                   'barang_gudang_cabangs.margin',
                   'barang_gudang_cabangs.harga_jual',
                   'barang_gudang_cabangs.sub_total_pokok',
                   'barang_gudang_cabangs.sub_total_jual')
                   ->get();
        // dd($gudangcabang);
        $big_total =BarangGudangCabang::where('cabang_id',$cabang)
        ->where('nama_gudang',$hak_akses)
        ->sum('sub_total_jual');
        return view('gudangcabang/index',compact('cabang','gudangcabang','pilih','hak_akses','big_total'));
    }

    public function pinjam(Request $request){

        $pinjam = $request->pilih;
        // dd($pinjam);
        $id_peminjam = Auth::user()->id;
        $satuan = SatuanModel::all();
        $date = new DateTime();
        $ldate = date('Y-m-d');
        $cabang1 = "PIN";
        $bahanbaku = GudangCabangModel::where('cabang_id',$pinjam)->get();
        $pilcab = CabangModel::where('fungsi','=','warehouse')->get();
        $cabang = CabangModel::all();
        $req = PurchaseModel::select('no_purchase')->orderby('created_at','desc')->first();

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

        return view('gudangcabang/pinjam',compact('id_peminjam','pinjam','cabang1','cabang','kode','date','req','satuan','ldate','bahanbaku','pilcab'));
    }

    public function pinjaman(Request $request)
    {
        $no_peminjaman  = $request->no_peminjaman;
        $tgl_peminjaman = $request->tanggal_peminjaman;
        $id_peminjam    = Auth::user()->cabang_id;
        $id_cabang    = $request->id_cabang;
        $ldate        = date('Y-m-d');
        $minggu2      = date('Y-m-d', strtotime('+2 week', strtotime($ldate)));
        $big_total    = $request->big_total;
        $status       = "Pinjam";
        

        foreach($request->id_bahanbaku as $key => $value)
        {
            $input = new PeminjamanModel(); 
            $input->no_peminjaman = $no_peminjaman; 
            $input->id_cabang = $id_cabang; 
            $input->id_barang = $value;
            $input->id_peminjam = $id_peminjam;
            $bahanbaku = GudangCabangModel::where('id',$value)->get();
            foreach($bahanbaku as $bah){
                $id = $bah->id;
                $hargaup = ($bah->harga_up);
                $hargapk = $bah->harga_pk;
                $berat = $bah->berat;
                $id_satuan = $bah->id_satuan;

            }

            $input->berat = $berat;
            $input->id_satuan = $id_satuan;
            $input->harga_pk = $hargapk;
            $input->harga = $hargapk;
            $input->quantity = $request->quantity[$key];
            $rego = $hargaup;
            $akehe = $request->quantity[$key];
            $sub = ($rego * $akehe);
            $input->sub_total = $sub;
            $input->status = "Open";
            $input->save();
        }

        InvoicePeminjamanModel::create([
                'no_peminjaman' => $no_peminjaman,
                'tanggal_peminjam' => $ldate,
                'due_date' => $minggu2,
                'id_cabang' => $id_cabang,
                'id_peminjam' => $id_peminjam,
                'due_date' => $minggu2,
                'big_total' => "0",
                'bayar' => "0",
                'sisa' => "0",
                'status' => "Pinjam"

            ]);
        // dd($hargaup);
        return back()->with('success', 'Record Created Successfully.');
    }

    public function tampil_peminjaman(){

        $user = Auth::user()->cabang_id;
        $tampil = InvoicePeminjamanModel::join('cabang','invoice_peminjaman_models.id_peminjam','cabang.id')
        ->where('id_cabang',$user)
        ->select('invoice_peminjaman_models.id',
                'invoice_peminjaman_models.no_peminjaman',
                'cabang.nama_cabang',
                'invoice_peminjaman_models.tanggal_peminjam',
                'invoice_peminjaman_models.due_date',
                'invoice_peminjaman_models.big_total',
                'invoice_peminjaman_models.bayar',
                'invoice_peminjaman_models.sisa',
                'invoice_peminjaman_models.status')
                ->orderBy('invoice_peminjaman_models.id','desc')
                ->get();
                $sum = InvoicePeminjamanModel::where('id_cabang',$user)->sum('big_total');
                $bayar = InvoicePeminjamanModel::where('id_cabang',$user)->sum('bayar');
                $sisa = InvoicePeminjamanModel::where('id_cabang',$user)->sum('sisa');
        // dd($tampil);
        return view('peminjaman/index',compact('tampil','user','sum','bayar','sisa'));
    }

    public function editqty($id){
        $detail = InvoicePeminjamanModel::find($id);
        $no_pinjam = $detail->no_peminjaman;

        $isi = PeminjamanModel::join('gudang_cabang_models','peminjaman_models.id_barang','gudang_cabang_models.id')
        ->join('satuan_models','peminjaman_models.id_satuan','satuan_models.id')
        ->join('cabang','peminjaman_models.id_cabang','cabang.id')
        // ->join('users','peminjaman_models.id_peminjam','users.id')
        ->where('no_peminjaman',$no_pinjam)
        ->select('peminjaman_models.id',
                'peminjaman_models.no_peminjaman',
                'gudang_cabang_models.nama_barang',
                'peminjaman_models.berat',
                'satuan_models.nama_satuan',
                'peminjaman_models.harga_pk',
                'peminjaman_models.harga',
                'peminjaman_models.quantity',
                'peminjaman_models.sub_total',
                'peminjaman_models.status',
                'cabang.nama_cabang')
        // ->select('gudang_cabang_models.nama_barang',
        // 'satuan_models.nama_satuan',
        // 'cabang.nama_cabang')
        ->get();
        return view('peminjaman/detail',compact('detail','no_pinjam','isi'));
    }
    
    public function tocabang(){

        $user = Auth::user()->cabang_id;
        $tocabang = InvoicePeminjamanModel::join('cabang','invoice_peminjaman_models.id_cabang','cabang.id')
        ->where('id_peminjam',$user)
        ->select('invoice_peminjaman_models.id',
                'invoice_peminjaman_models.no_peminjaman',
                'cabang.nama_cabang',
                'invoice_peminjaman_models.tanggal_peminjam',
                'invoice_peminjaman_models.due_date',
                'invoice_peminjaman_models.big_total',
                'invoice_peminjaman_models.bayar',
                'invoice_peminjaman_models.sisa',
                'invoice_peminjaman_models.status')
                ->orderBy('invoice_peminjaman_models.id','desc')
                ->get();
                $sum = InvoicePeminjamanModel::where('id_peminjam',$user)->sum('big_total');
                $bayar = InvoicePeminjamanModel::where('id_peminjam',$user)->sum('bayar');
                $sisa = InvoicePeminjamanModel::where('id_peminjam',$user)->sum('sisa');
        return view('peminjaman/tocabang',compact('user','tocabang','sum','bayar','sisa'));
    }


    public function tostok($id){
        $tampil = PeminjamanModel::find($id);
        $tampil->update(['status' => "in stok"]);
        $barang =  $tampil->id_barang;
        $id_peminjam = $tampil->id_peminjam;
        $gudangs = GudangCabangModel::where('id',$barang)->get();

        foreach($gudangs as $guudd){
            $nama_bahanbaku = $guudd->nama_barang;
        }
        $berat = $tampil->berat;
        $satuan = $tampil->id_satuan;
        $harga_pk = $tampil->harga_pk;
        $harga_up = $tampil->harga;
        $stok = $tampil->quantity;
        $cabang = Auth::user()->cabang_id;
        $hak = Auth::user()->hak_akses;
        $cek = GudangCabangModel::where('nama_barang','like',"%".$nama_bahanbaku."%")->where('cabang_id',$cabang)->count();
        // $tes = GudangCabangModel::where('nama_barang','like',"%".$nama_bahanbaku."%")
        // ->where('harga_pk','<',$harga_pk)->count();
        
            if($cek){
                $up = GudangCabangModel::where('nama_barang','like',"%".$nama_bahanbaku."%")
                ->where('cabang_id',$id_peminjam)
                ->update([
                    'stok'=> DB::raw("stok + $stok"),
                    'harga_pk'=>DB::raw($harga_pk),
                    'harga_up'=>$harga_up
                ]);
    
            }
                  else{
                $hust = GudangCabangModel::insert(['nama_barang'=>$nama_bahanbaku,
                'harga_pk'=>$harga_pk,
                'harga_up'=>$harga_up,
                'stok'=>$stok,
                'berat' => $berat,
                'id_satuan' => $satuan,
                'cabang_id'=>$cabang,
                'gudang'=>$hak]);
            }
        
        // dd($cek);
        return redirect()->back();
    }

    public function formbayar(Request $request,$id){
        $find = InvoicePeminjamanModel::find($id);
        $no_peminjaman = $find->no_peminjaman;
        $sisa = $find->sisa;
        // dd($no_purch);
        return view('peminjaman.bayar',compact('find','no_peminjaman','sisa'));
    }
    public function detailbayar($id){
        $tampil = InvoicePeminjamanModel::find($id);
        $no_peminjaman = $tampil->no_peminjaman;

        $pembayaran = BayarHutangCabangModel::where('no_peminjaman',$no_peminjaman)
        ->get();
        $sum = BayarHutangCabangModel::where('no_peminjaman',$no_peminjaman)->sum('nominal');

        return view('peminjaman.detailbayar',compact('tampil','no_peminjaman','pembayaran','sum'));
    }

    public function printpeminjaman($id){

        $pin = InvoicePeminjamanModel::find($id);
        $no = $pin->no_peminjaman;
        $tgl = $pin->tanggal_peminjam;
        $big_total = $pin->big_total;
        $bayar = $pin->bayar;
        $sisa = $pin->sisa;
        $due_date = $pin->due_date;
        $peminjam = $pin->id_peminjam;
        $cabang = CabangModel::where('id',$peminjam)->get();
       
        
        $isi = PeminjamanModel::join('gudang_cabang_models','peminjaman_models.id_barang','gudang_cabang_models.id')
        ->join('satuan_models','peminjaman_models.id_satuan','satuan_models.id')
        ->join('cabang','peminjaman_models.id_cabang','cabang.id')
        // ->join('users','peminjaman_models.id_peminjam','users.id')
        ->where('no_peminjaman',$no)
        ->select('peminjaman_models.id',
                'peminjaman_models.no_peminjaman',
                'gudang_cabang_models.nama_barang',
                'peminjaman_models.berat',
                'satuan_models.nama_satuan',
                'peminjaman_models.harga_pk',
                'peminjaman_models.harga',
                'peminjaman_models.quantity',
                'peminjaman_models.sub_total',
                'peminjaman_models.status',
                'cabang.nama_cabang')
        // ->select('gudang_cabang_models.nama_barang',
        // 'satuan_models.nama_satuan',
        // 'cabang.nama_cabang')
        ->get();
        // dd($pu);
        return view('peminjaman.print',compact('cabang','pin','no','tgl','big_total','bayar','sisa','due_date','isi'));
    }

    public function detailbayartocabang($id){
        $tampil = InvoicePeminjamanModel::find($id);
        $no_peminjaman = $tampil->no_peminjaman;

        $pembayaran = BayarHutangCabangModel::where('no_peminjaman',$no_peminjaman)
        ->get();
        $sum = BayarHutangCabangModel::where('no_peminjaman',$no_peminjaman)->sum('nominal');

        return view('peminjaman.detailbayarcabang',compact('tampil','no_peminjaman','pembayaran','sum'));
    }

    public function inputbayar(Request $request){
        $input = new BayarHutangCabangModel();
        $input->no_peminjaman = $request->no_peminjaman;
        $input->nominal = $request->nominal;
        $input->save();
        $no_peminjaman = $request->no_peminjaman;
        $nominal = $request->nominal;
        $bayar = BayarHutangCabangModel::where('no_peminjaman',$no_peminjaman)->sum('nominal');

        $up = InvoicePeminjamanModel::where('no_peminjaman',$no_peminjaman)->update([
            'bayar'=> $bayar,'sisa' => DB::raw("sisa - $nominal")
        ]);
        // dd($up);
        return back()->with('success', 'Record Created Successfully.');
    }

    public function aksieditqty(Request $request,$id){
        $qua = PeminjamanModel::find($id);
        $no  = $qua->no_peminjaman;
        $no_purchase = InvoicePeminjamanModel::where('no_peminjaman',$no)->get();
        $newqty = $request->quantity;
        $newsub = $qua->harga;
        $subtot = $newqty*$newsub;
        $qua->update(['quantity'=>"$newqty",'sub_total'=>$subtot]);
        
        return back();
    }

    public function ditolak($id){
        $tampil = PeminjamanModel::find($id);
        $tampil->update(['status' => "diTolak"]);
       
        // dd($tampil2);
        return redirect()->back();
    }


    public function detail_pinjam($id){

        $detail = InvoicePeminjamanModel::find($id);
        $no_pinjam = $detail->no_peminjaman;

        $isi = PeminjamanModel::join('gudang_cabang_models','peminjaman_models.id_barang','gudang_cabang_models.id')
        ->join('satuan_models','peminjaman_models.id_satuan','satuan_models.id')
        ->join('cabang','peminjaman_models.id_cabang','cabang.id')
        // ->join('users','peminjaman_models.id_peminjam','users.id')
        ->where('no_peminjaman',$no_pinjam)
        ->select('peminjaman_models.id',
                'peminjaman_models.no_peminjaman',
                'gudang_cabang_models.nama_barang',
                'peminjaman_models.berat',
                'satuan_models.nama_satuan',
                'peminjaman_models.harga_pk',
                'peminjaman_models.harga',
                'peminjaman_models.quantity',
                'peminjaman_models.sub_total',
                'peminjaman_models.status',
                'cabang.nama_cabang')
        // ->select('gudang_cabang_models.nama_barang',
        // 'satuan_models.nama_satuan',
        // 'cabang.nama_cabang')
        ->get();
        // dd($isi);
        return view('peminjaman/detail',compact('detail','no_pinjam','isi'));
    }
    public function detailtocabang($id){

        $detail = InvoicePeminjamanModel::find($id);
        $no_pinjam = $detail->no_peminjaman;

        $isi = PeminjamanModel::join('gudang_cabang_models','peminjaman_models.id_barang','gudang_cabang_models.id')
        ->join('satuan_models','peminjaman_models.id_satuan','satuan_models.id')
        ->join('cabang','peminjaman_models.id_cabang','cabang.id')
        // ->join('users','peminjaman_models.id_peminjam','users.id')
        ->where('no_peminjaman',$no_pinjam)
        ->select('peminjaman_models.id',
                'peminjaman_models.no_peminjaman',
                'gudang_cabang_models.nama_barang',
                'peminjaman_models.berat',
                'satuan_models.nama_satuan',
                'peminjaman_models.harga_pk',
                'peminjaman_models.harga',
                'peminjaman_models.quantity',
                'peminjaman_models.sub_total',
                'peminjaman_models.status',
                'cabang.nama_cabang')
        // ->select('gudang_cabang_models.nama_barang',
        // 'satuan_models.nama_satuan',
        // 'cabang.nama_cabang')
        ->get();
        // dd($isi);
        return view('peminjaman/detailtocabang',compact('detail','no_pinjam','isi'));
    }

    public function setujui($id){
        $tampil = PeminjamanModel::find($id);
        $id = $tampil->id;
        $no = $tampil->no_peminjaman;
        $harga_pk = $tampil->harga_pk;
        $harga_up = $tampil->harga;
        $qty = $tampil->quantity;
        $subtotal = $tampil->sub_total;
        $nama_gudang = $tampil->id_cabang;
        $peminjam = $tampil->id_peminjam;
        $id_bahanbaku = $tampil->id_barang;
        $tampil->update(['status' => "ready"]);
        $sub = ($harga_up * $qty);
        // $ubahsub = PeminjamanModel::where('id_barang',$nama_gudang)->update(['sub_total' => $sub]);
        $tampil2 = PeminjamanModel::where('no_peminjaman',$no)->where('status','=','ready')->sum('sub_total');
        $ubah = InvoicePeminjamanModel::where('no_peminjaman',$no)->update(['big_total' => $tampil2,'sisa' => $tampil2]);
        
        $input = new PiutangCabangModel();
        $input->no_peminjaman = $no;
        $input->id_peminjaman = $id;
        $input->id_barang = $id_bahanbaku;
        $input->harga_pk = $harga_pk;
        $input->harga_up = $harga_up;
        $input->quantity = $qty;
        $sub_pk = $harga_pk * $qty;
        $input->sub_totalpk = $sub_pk;
        $input->sub_total = $subtotal;
        $input->id_cabang = $nama_gudang;
        $input->id_peminjam = $peminjam;
        $input->save();

        $up = GudangCabangModel::where('id',$id_bahanbaku)->where('cabang_id',$nama_gudang)->update([
            'stok'=> DB::raw("stok - $qty"),'sub_total'=> DB::raw("harga_up * stok")
        ]);
        // dd($tampil);
        return redirect()->back();

    }

    public function filter(Request $request)
    {
        $pilih = CabangModel::all();
        $pil = $request->pilih;
        $cabang = Auth::user()->cabang_id;
        $gudangcabang = BarangGudangCabang::join('satuan_models','barang_gudang_cabangs.id_satuan','satuan_models.id')
        ->where('barang_gudang_cabangs.cabang_id',$pil)
        ->select('barang_gudang_cabangs.id',
                  'barang_gudang_cabangs.code_barang_model',
                   'barang_gudang_cabangs.nama_barang',
                   'barang_gudang_cabangs.berat',
                   'satuan_models.nama_satuan',
                   'barang_gudang_cabangs.stok',
                   'barang_gudang_cabangs.harga_pokok',
                   'barang_gudang_cabangs.margin',
                   'barang_gudang_cabangs.harga_jual',
                   'barang_gudang_cabangs.sub_total_pokok',
                   'barang_gudang_cabangs.sub_total_jual')
                   ->get();
        $big_total =BarangGudangCabang::where('cabang_id',$pil)
        ->where('nama_gudang','=',"AdminGudangCabang")
        ->sum('sub_total_jual');
        // dd($gudangcabang);
        return view('gudangcabang/index',compact('big_total','cabang','gudangcabang','pilih','pil'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $satuan = SatuanModel::all();
        $barang = BarangGudang::join('satuan_models','barang_gudangs.id_satuan','satuan_models.id')
        ->select('barang_gudangs.id',
                 'barang_gudangs.code_barang_model',
                 'barang_gudangs.nama_barang',
                 'satuan_models.nama_satuan',
                 'barang_gudangs.harga_jual')
                 ->get();

        return view('gudangcabang/create',compact('satuan','barang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cek_Data1 = Auth::user()->cabang_id;
        $gudang = Auth::user()->hak_akses;
        // $bahanbaku = BahanbakuModel::where('id',$id)->get();
        // $harga_pk = $bahanbaku->harga_pk;
        // $harga_up = $bahanbaku->harga_up;
        // $harga_new = ($harga_pk * ($harga_up/100));

        $request->validate([
            'addmore.*.cabang_id' => $cek_Data1,
            'addmore.*.code_barang_model',
            'addmore.*.nama_barang',
            'addmore.*.harga_pokok',
            'addmore.*.harga_jual',
            'addmore.*.id_gudang' => $gudang,
            'addmore.*.stok' ,
            'addmore.*.berat',
            'addmore.*.id_satuan'
            
        ]);
    
        foreach ($request->addmore as $key => $value) {
            $id = $value['code_barang_model'];
            // $stok = $value['stok'];
            // $mar = $value['margin'];            // $bahanbaku = BahanbakuModel::where('id',$id)->get();
            // foreach($bahanbaku  as $bah){
            //     $hpk =  $bah->harga_pk;
            //     $hup = $bah->harga_up;
            // }
            // $margin = (*($mar/100));
            $barang = BarangGudang::where('code_barang_model',$id)->get();
            foreach($barang as $bar){
                $namabarang = $bar->nama_barang;
                // $harga_pokok = $bar->harga_pokok;
                $berat = $bar->berat;
                $id_satuan = $bar->id_satuan;
                $stok = "0";
                $harga_jual = $bar->harga_jual;
                $harga_pokok = $bar->harga_pokok;


            }
            $cek = BarangGudangCabang::where('code_barang_model',$id)->count();
            if($cek){
                $up = BarangGudangCabang::where('code_barang_model',$id)->update([
                    'stok'=> DB::raw("stok + $stok")
                ]);
            }
            else{
                $insert = BarangGudangCabang::create([
                    'cabang_id' => Auth::user()->cabang_id,
                    'gudang' => $gudang,
                    'code_barang_model' => $id,
                   
                    'nama_barang' => $namabarang,
                    'harga_pokok' => $harga_jual,
                    'margin' => $value['margin'],
                    $margin = $value['margin'],
                    'harga_jual' => $harga_jual + $margin,
                    $up = $harga_jual + $margin,
                    'stok' => $stok,
                    'berat' => $berat,
                    'id_satuan' => $id_satuan,
                    'sub_total_pokok' => $harga_jual * $stok,
                    'sub_total_jual' => $up * $stok,
                    'nama_gudang' =>Auth::user()->hak_akses

    
                ]);
            }

            
           
        }
        // dd($barang);
    
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
        $edit = BarangGudangCabang::find($id);
        // $id = $edit->id;

        // dd($edit);
        return view('gudangcabang.edit',compact('edit'));
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
        $update = BarangGudangCabang::find($id);
        $update->nama_barang = $request->nama_barang;
        $update->harga_pokok = $request->harga_pokok;
        $update->margin = $request->margin;
        $harga_pokok = $request->harga_pokok;
        $margin = $request->margin;
        $update->harga_jual = $harga_pokok + $margin;
        $harga_jual = $harga_pokok + $margin;
        $stok = $update->stok;
        $update->sub_total_pokok = $harga_pokok * $stok;
        $update->sub_total_jual = $harga_jual * $stok;
        $update->save(); 
        return back()->with('success', 'Record Created Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BarangGudangCabang::find($id)->delete();
        return back()->with('pesan','berhasil di hapus');
    }
}
