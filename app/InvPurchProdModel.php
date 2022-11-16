<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvPurchProdModel extends Model
{
    protected $table = "inv_purch_prod_models";
    protected $fillable = [ 'no_purchase',
                            'id_user',
                            'tanggal_purchase',
                            'nama_gudang',
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
