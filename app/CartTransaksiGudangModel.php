<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartTransaksiGudangModel extends Model
{
    protected $table = "cart_transaksi_gudang_models";
    protected $fillable = ['id',
                            'no_invoice',
                            'user_id',
                            'id_barang',
                            'harga_pk',
                            'harga_up',
                            'qty',
                            'discount',
                            'cut_sale',
                            'sub_total',
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
