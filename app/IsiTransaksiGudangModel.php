<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IsiTransaksiGudangModel extends Model
{
    protected $table = "isi_transaksi_gudang_models";
    protected $fillable = ['id',
                            'no_invoice',
                            'id_barang',
                            'harga_pk',
                            'harga_up',
                            'qty',
                            'discount',
                            'cut_sale',
                            'sub_total',
                            'tanggal_transaksi'
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
