<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPurchase extends Model
{
    protected $table = "detail_purchases";
    protected $fillable = ['id',
                            'no_purchase',
                            'code_barang_model',
                            'berat',
                            'id_satuan',
                            'harga_pk',
                            'harga',
                            'quantity',
                            'sub_total_pokok',
                            'sub_total_jual',
                            'status',
                            'nama_gudang'
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
