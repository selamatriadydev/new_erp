<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartRetail extends Model
{
    protected $table = "cart_retails";
    protected $fillable = ['code_item','jumlah','harga_pk','margin','harga_up','disc','cut_sale','subtotal_pk','subtotal_up','cabang_id','id_user'];

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
