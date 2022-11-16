$id_user = Auth::user()->id;
        $namane = Auth::user()->name;
        $cabang  = Auth::user()->cabang_id;
        $namacabang = CabangModel::where('id',$cabang)->select('nama_cabang')->get();
        foreach($namacabang as $nc){
            $namcab = $nc->nama_cabang;
        }
        $invoice = $request->no_invoice;
        $bayar   = $request->bayar;
        $cart = CartTransaksiGudangModel::where('user_id',$id_user)->get();
        $big_total = CartTransaksiGudangModel::where('user_id',$id_user)->sum('sub_total');
        
        dd($invoice);
        foreach($cart as $carts){
            $ceks = InvoicingTransaksiGudangModel::where('no_invoice',$invoice)->count();
            if($ceks){

            }
            else{
                $input = new InvoiceTransaksiGudangModel();
                $input->no_invoice = $request->no_invoice;
                $input->id_barang = $carts->id_barang;
                $input->harga_pk  = $carts->harga_pk;
                $input->harga_up  = $carts->harga_up;
                $input->qty       = $carts->qty;
                $input->discount  = $carts->discount;
                $input->cut_sale  = $carts->cut_sale;
                $input->sub_total = $carts->sub_total; 
                $input->cabang_id = $carts->cabang_id; 
                $input->save();
            }
      
        }
        $cek = InvoicingTransaksiGudangModel::where('no_invoice',$invoice)->count();
        if($cek){
            
        }
        else{
            InvoicingTransaksiGudangModel::create([
                'no_invoice'  => $invoice,
                'cabang_id'   => $cabang,
                'id_user'     => $id_user,
                'tanggal_transaksi'  => date('Y-m-d'),
                'big_total'   => $big_total,
                'bayar'       => $bayar,
                'sisa'        => ($bayar - $big_total),
                'status'      => "ok" 
            ]);
        }
        
        $print = InvoicingTransaksiGudangModel::where('id_user',$id_user)
        ->where('no_invoice',$invoice)
        ->select('no_invoice',
                'tanggal_transaksi',
                'id_user',
                'big_total',
                'bayar',
                'sisa')
                ->get();
        $loopbarang = InvoiceTransaksiGudangModel::join('satuan_barang_models','invoice_transaksi_gudang_models.id_barang','satuan_barang_models.id')
                    ->join('satuan_models','satuan_barang_models.id_satuan','satuan_models.id')
                    ->where('no_invoice',$invoice)
                    ->select('satuan_barang_models.nama_barang'
                    ,'satuan_barang_models.harga_up'
                    ,'invoice_transaksi_gudang_models.qty'
                    ,'invoice_transaksi_gudang_models.sub_total',
                    'satuan_models.nama_satuan')
                    ->orderBy('satuan_barang_models.id','desc')
                    ->get();
        $invo = InvoiceTransaksiGudangModel::where('no_invoice',$invoice)->get();
        foreach($invo as $invos){
            $barangs = $invos->id_barang;
            $cabangs = $invos->cabang_id;
            $qtys    = $invos->qty;
        }
        $satuanm = SatuanBarangModel::where('id',$barangs)->count();
        $satuans = SatuanBarangModel::where('id',$barangs)->get();
        if($satuanm){
        foreach($satuans as $sat){
            $nooo =  $sat->no;
            $smn = $sat->id_satuan;
            $v = $sat->value_satuan;
        }
        }
        if($nooo == "1"){
            $jajal = SatuanBarangModel::where('id',$barangs)->where('no','=',"1")->update(['stok' => DB::raw("stok - $qtys")]);
            $get1 = SatuanBarangModel::where('no','=',"1")->where('id',$barangs)->get();
            $get16 = SatuanBarangModel::where('no','=',"1")->where('id',$barangs)->count();
            if($get16){
            foreach($get1 as $gee){
                $stk = $gee->stok;
                $stk2 = $gee->value_satuan;
                $nama = $gee->nama_barang;
            }
            }
            $jajal2 = SatuanBarangModel::where('nama_barang',$nama)->where('no','=',"2")
            ->update(['stok' => DB::raw("value_satuan * $stk")]);
            $get2 = SatuanBarangModel::where('no','=',"2")->where('nama_barang',$nama)->get();
            $get27 = SatuanBarangModel::where('no','=',"2")->where('nama_barang',$nama)->count();
            if($get27){
            foreach($get2 as $gees){
                $stks = $gees->stok;
                $stks2 = $gees->value_satuan;
            }
            $jajal3 = SatuanBarangModel::where('nama_barang',$nama)->where('no','=',"3")
            ->update(['stok' => DB::raw("value_satuan * $stks")]);
            }
        }
        elseif($nooo == "2"){
            $jajale = SatuanBarangModel::where('id',$barangs)->where('no','=',"2")->update(['stok' => DB::raw("stok - $qtys")]);
            $gete1 = SatuanBarangModel::where('no','=',"2")->where('id',$barangs)->get();
            $gete12 = SatuanBarangModel::where('no','=',"2")->where('id',$barangs)->count();
            if($gete12){
            foreach($gete1 as $geee){
                $names =  $geee->nama_barang;
                $stke = $geee->stok;
                $stke2 = $geee->value_satuan;
                
            }
            }
            $jujur =  SatuanBarangModel::where('no','=',"1")->where('nama_barang',$names)->get();
            
            $jujur3 =  SatuanBarangModel::where('no','=',"1")->where('nama_barang',$names)->count();
            if($jujur3){
            foreach($jujur as $jur){
                $jj = $jur->stok;
                $valr =  $jur->value_satuan;
                $namas = $jur->nama_barang;

            }
            
            $gsie  = $stke2/$valr;
            $bagilah = $stke/$gsie;
            $jajal2 = SatuanBarangModel::where('nama_barang',$namas)->where('no','=',"1")
            ->update(['stok' => $bagilah]);
            }
            $jujuro =  SatuanBarangModel::where('no','=',"3")->where('nama_barang',$namas)->get();
            $jujuro56 =  SatuanBarangModel::where('no','=',"3")->where('nama_barang',$namas)->count();
            if($jujuro56){
            foreach($jujuro as $juro){
                $jjo = $juro->stok;
                $valro =  $juro->value_satuan;
                $n  =  $juro->nama_barang;
            }
            
            $gsieo  = $valro/$stke2;
            $bagilaho = $stke*$gsieo;
            $jajal3 = SatuanBarangModel::where('nama_barang',$n)->where('no','=',"3")
            ->update(['stok' => $bagilaho]);
            }
        }
        elseif($nooo == "3"){
            $jajalen = SatuanBarangModel::where('id',$barangs)->where('no','=',"3")->update(['stok' => DB::raw("stok - $qtys")]);
            $geten1 = SatuanBarangModel::where('no','=',"3")->where('id',$barangs)->get();
            $geten18 = SatuanBarangModel::where('no','=',"3")->where('id',$barangs)->count();
            if($geten18){
            foreach($geten1 as $gen){
                $stken = $gen->stok;
                $stken2 = $gen->value_satuan;
                $nbarangs = $gen->nama_barang;
            }
            }
            $susahwes = SatuanBarangModel::where('no','=',"2")->where('nama_barang',$nbarangs)->get();
            
            $susahwesi = SatuanBarangModel::where('no','=',"2")->where('nama_barang',$nbarangs)->count();
            if($susahwesi){
            foreach($susahwes as $su){
                $val = $su->value_satuan;
                
            }
            $bangsatlah = $stken2/$val;
            $yuks = $stken/$bangsatlah;
            $jajaln3 = SatuanBarangModel::where('nama_barang',$nbarangs)->where('no','=',"2")
            ->update(['stok' => $yuks]);
            }
            $getajajaln3 = SatuanBarangModel::where('nama_barang',$nbarangs)->where('no','=',"2")->get();
            
            $getajajaln32 = SatuanBarangModel::where('nama_barang',$nbarangs)->where('no','=',"2")->count();
            if($getajajaln32){
            foreach($getajajaln3 as $gy){
                $stkeny = $gy->stok;
                $stkeny2 = $gy->value_satuan;
                $bagilahny = $stkeny/$stkeny2;
                $nabar = $gy->nama_barang;
            }
            }
            $cook = SatuanBarangModel::where('no','=',"1")->where('nama_barang',$nabar)->get();
            
            $cookis = SatuanBarangModel::where('no','=',"1")->where('nama_barang',$nabar)->count();
            if($cookis){
            foreach($cook as $sutel){
                $vale = $sutel->value_satuan;
            }
            $bangsatlahi = $stkeny2/$vale;
            $buram = $stkeny/$bangsatlahi;
            $jajaln4 = SatuanBarangModel::where('nama_barang',$nabar)->where('no','=',"1")
            ->update(['stok' => $buram]);
        }
        }
        else{

        }
        $hapus = CartTransaksiGudangModel::where('user_id',$id_user)
        ->delete();
        // dd($invo);