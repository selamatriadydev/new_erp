<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PotonganHarga extends Model
{
    protected $table = "potongan_hargas";
    protected $fillable = [ 'id',
                            'id_produk',
                            'range1',
                            'range2',
                            'potongan'];

    public function cabang(){
        return $this->belongsTo('App\CabangModel');
    }
    public function bahanbaku(){
        return $this->belongsTo('App\BahanbakuModel');
    }
    public function supplier(){
        return $this->belongsTo('App\SupplierModel');
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
