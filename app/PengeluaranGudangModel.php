<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengeluaranGudangModel extends Model
{
    protected $table = "pengeluaran_gudang_models";
    protected $fillable = ['no_pengeluaran',
                            'id_guna',
                            'nama_barang',
                            'jumlah',
                            'nominal',
                            'total_price',
                            'total',
                            'id_user',
                            'cabang_id',
                            'hak_akses',
                            'tanggal_pengeluaran'
                        ];

    public function cabang(){
        return $this->belongsTo('App\CabangModel');
    }
    public function purchasing(){
        return $this->belongsTo('App\PurchasingModel');
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
