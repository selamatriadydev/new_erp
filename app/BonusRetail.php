<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BonusRetail extends Model
{
    protected $table = "bonus_retails";
    protected $fillable = ['code_item','id_item','harga_pk','margin','harga_up','qty','subtotal_pk','subtotal_up','cabang_id','user_id','tanggal_keluar'];

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
