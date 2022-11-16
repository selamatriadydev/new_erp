<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchasingModel extends Model
{
    protected $table = "purchasing_models";
    protected $fillable = [ 'no_purchase',
                            'cabang_pembuat',
                            'cabang_tujuan',
                            'purchasers',
                            'tanggal_purchase',
                            'nama_gudang',
                            'due_date',
                            'big_total',
                            'bayar',
                            'sisa',
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
