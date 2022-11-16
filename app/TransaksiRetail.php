<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiRetail extends Model
{
    protected $table = "transaksi_retails";
    protected $fillable = ['no_nota','tanggal_transaksi','subtotal_pk','sub_total_up','bayar','kembali','cabang_id','user_id'];

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
