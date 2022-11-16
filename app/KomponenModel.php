<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KomponenModel extends Model
{
    protected $table = "komponen_models";
    protected $fillable = ['nama_komponen','id_item','hpp','total_hpp','harga_jual','total_harga_jual','cabang_id'];

    public function cabang(){
        return $this->belongsTo('App\CabangModel');
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
