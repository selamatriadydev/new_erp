<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengeluaranBahan extends Model
{
    protected $table = "pengeluaran_bahans";
    protected $fillable = ['id',
                            'no_Invoice',
                           'id_item',
                           'id_bahanbaku',
                           'gramasi',
                           'id_satuan',
                           'total_harga',
                           'tanggal_produksi',
                           'cabang_id'
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
