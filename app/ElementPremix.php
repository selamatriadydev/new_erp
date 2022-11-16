<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElementPremix extends Model
{
    protected $table = "element_premixes";
    protected $fillable = ['code_barang_model','id_barang','harga','berat','id_satuan','cabang_id','subtotal','nama_gudang'];

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
