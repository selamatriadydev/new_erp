<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";
    protected $fillable = ['no_invoice',
    'nama_cust',
    'jenis_cust',
    'cabang_id',
    'user_id',
    'tanggal_kirim',
    'tanggal_masuk',
    'jam_kirim',
    'no_telp',
    'jenis_order',
    'id_kota',
    'id_kec',
    'id_keluaran',
    'jalan',
    'patokan',
    'bigtotal',
    'bayar',
    'sisa',
    'status',
    'alasan',
    'keterangan'];

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
