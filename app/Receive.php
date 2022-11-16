<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receive extends Model
{
    protected $table = "receives";
    protected $fillable = ['no_receive',
                        'no_invoices',
                        'tanggal_terima',
                        'tanggal_invoice',
                        'id_supplier',
                        'sub_total',
                        'ppn',
                        'big_total',
                        'big_totals',
                        'terbayar',
                        'sisa',
                        'keterangan',
                        'due_date',
                        'cabang_id'];

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
