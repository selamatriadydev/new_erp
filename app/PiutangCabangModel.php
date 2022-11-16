<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PiutangCabangModel extends Model
{
    protected $table = "piutang_cabang_models";
    protected $fillable = ['no_peminjaman',
                            'id_peminjaman',
                           'id_barang',
                           'harga_pk',
                           'harga_up',
                           'quantity',
                           'sub_totalpk',
                           'sub_total',
                           'id_cabang',
                           'id_peminjam'];

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
