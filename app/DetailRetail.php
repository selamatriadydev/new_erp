<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailRetail extends Model
{
    protected $table = "detail_retails";
    protected $fillable = ['no_nota','tanggal_transaksi','code_item','harga_pk','margin','harga_up','jumlah','disc','cut_sale','subtotal_pk','subtotal_up','cabang_id','user_id'];

    public function cabang(){
        return $this->belongsTo('App\CabangModel');
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
