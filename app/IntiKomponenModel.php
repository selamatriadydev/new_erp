<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IntiKomponenModel extends Model
{
    protected $table = "inti_komponen_models";
    protected $fillable = ['nama_komponen','code_komponen','total_hpp','total_harga_jual','cabang_id'];

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
