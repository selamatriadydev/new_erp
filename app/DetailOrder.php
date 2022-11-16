<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    protected $table = "detail_orders";
    protected $fillable = ['no_invoice',
    'cabang_id',
    'user_id',
    'id_paket',
    'hpp',
    'harga',
    'qty',
    'disc',
    'cutsale',
    'subhpp',
    'subtotal',
    'tanggal_kirim',
    'jam_kirim',
    'status'];

    public function cabang(){
        return $this->belongsTo('App\CabangModel');
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
