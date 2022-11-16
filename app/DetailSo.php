<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailSo extends Model
{
    protected $table = "detail_sos";
    protected $fillable = [ 'no_order',
                            'id_produk',
                            'modal',
                            'jual',
                            'jumlah',
                            'sub_modal',
                            'sub_jual',
                            'status'];

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
