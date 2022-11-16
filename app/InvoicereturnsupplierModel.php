<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoicereturnsupplierModel extends Model
{
    protected $table = "invoicereturnsupplier_models";
    protected $fillable = ['no_return',
                            'no_invoice',
                            'tgl_return',
                            'tgl_invoice',
                            'id_supplier',
                            'sub_total',
                            'tax',
                            'big_total',
                            'status_return'
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
