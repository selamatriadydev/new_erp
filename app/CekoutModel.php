<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CekoutModel extends Model
{
    protected $table = "cekout";
    protected $fillable = ['no_inv','id_paket','qty','harga','disc','cut_sale','subtotal','cabang_id'];

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
