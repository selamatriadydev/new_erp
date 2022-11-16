<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceBarangMasukModel extends Model
{
    protected $table = "invoice_barang_masuk_models";
    protected $fillable = ['no_receive',
                           'no_invoice',
                           'tgl_terima',
                           'tgl_invoice',
                           'id_supplier',
                           'due_date',
                           'sub_total',
                           'tax',
                           'big_total',
                           'dp',
                           'sisa'];

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
