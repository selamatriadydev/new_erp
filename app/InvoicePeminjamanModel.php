<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoicePeminjamanModel extends Model
{
    protected $table = "invoice_peminjaman_models";
    protected $fillable = ['no_peminjaman',
    'id_cabang',
    'id_peminjam',
    'tanggal_peminjam',
    'id_peminjam',
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
