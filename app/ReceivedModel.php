<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceivedModel extends Model
{
    protected $table = "received_models";
    protected $fillable = ['id',
                            'no_receive',
                            'no_invoice',
                            'id_barang',
                            'berat',
                            'id_satuan',
                            'quantity',
                            'unit_price',
                            'total_price',
                            'status'
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
