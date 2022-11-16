<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KomposisiModel extends Model
{
    protected $table = "komposisi_models";
    protected $fillable = ['id_resep','id_bahanbaku','harga_up','quantity','total_harga_up','hasil_jadi','gramasi','id_satuan'];

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