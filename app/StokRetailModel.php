<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StokRetailModel extends Model
{
    protected $table = "stok_retail_models";
    protected $fillable = ['id_product','hpp','harga_jual','stok','sub_total','sub_totalpk','cabang_id'];

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
