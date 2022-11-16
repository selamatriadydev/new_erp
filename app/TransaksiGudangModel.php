<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiGudangModel extends Model
{
    protected $table = "transaksi_gudang_models";
    protected $fillable = ['id',
                            'no_invoice',
                            'nama_customer',
                            'total',
                            'discount',
                            'cut_sale',
                            'big_total',
                            'tanggal_transaksi',
                            'cabang_id'
                        ];

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