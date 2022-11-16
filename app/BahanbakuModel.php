<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BahanbakuModel extends Model
{
    protected $table = "bahanbaku";
    protected $fillable = ['nama_bahanbaku','harga_pk','harga_up','berat','id_satuan'];

    public function cabang(){
        return $this->belongsTo('App\CabangModel');
    }
    public function satuan(){
        return $this->belongsTo('App\SatuanModel');
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
