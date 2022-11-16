<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemOrder extends Model
{
    protected $table = "item_orders";
    protected $fillable = ['no_invoice','id_paket','cabang_id','id_item','qty','status'];

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
