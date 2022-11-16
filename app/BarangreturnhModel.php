<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangreturnhModel extends Model
{
    protected $table = "barangreturnh_models";
    protected $fillable = ['no_purchase','id_barang','qty','status','nama_gudang'];

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
