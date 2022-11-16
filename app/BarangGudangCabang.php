<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangGudangCabang extends Model
{
    protected $table = "barang_gudang_cabangs";
    protected $fillable = ['code_barang_model','nama_barang','berat','id_satuan','stok','harga_pokok','margin','harga_jual','sub_total_pokok','sub_total_jual','cabang_id','nama_gudang'];

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
