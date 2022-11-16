<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangMasukModel extends Model
{
    protected $table = "barang_masuk_models";
    protected $fillable = ['no_receive','no_invoices','tanggal_terima','tanggal_invoices','id_supplier','nama_barang','berat','id_satuan','harga','quantity','sub_total','big_total','ppn','big_totals','terbayar','keterangan','due_date'];

    public function cabang(){
        return $this->belongsTo('App\CabangModel');
    }
    public function bahanbaku(){
        return $this->belongsTo('App\BahanbakuModel');
    }
    

    public function order(){
        return $this->belongsTo('App\OrdertModel','order');
    }

    public function paket(){
        return $this->belongsTo('App\PaketModel','paket');
    }
    public function item(){
        return $this->belongsTo('App\ItemModel','item');
    }
}
