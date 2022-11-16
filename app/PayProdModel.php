<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayProdModel extends Model
{
    protected $table = "pay_prod_models";
    protected $fillable = ['id',
                            'no_purchase',
                            'nominal'
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
