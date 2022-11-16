<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GudangCabangModel extends Model
{
    protected $table = "gudang_cabang_models";
    protected $fillable = ['nama_barang','harga_pk','harga_up','stok','sub_total','sub_totalpk','berat','id_satuan','cabang_id','gudang'];

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
