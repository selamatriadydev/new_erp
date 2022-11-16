<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PelunasanOrder extends Model
{
    protected $table = "pelunasan_orders";
    protected $fillable = ['id',
                           'no_invoice',
                           'nominal',
                           'tanggal_masuk',
                           'cabang_id',
                           'user_id'
                        ];

    public function cabang(){
        return $this->belongsTo('App\CabangModel');
    }
    public function purchasing(){
        return $this->belongsTo('App\PurchasingModel');
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
