<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = "order";
    protected $fillable = ['no_inv','cabang_id','nama_pemesan','no_hp','tgl_kirim','jam_kirim','alamat','tgl_order','big_total'];

    public function cabang(){
        return $this->belongsTo('App\CabangModel');
    }


    public function paket(){
        return $this->belongsTo('App\PaketModel','paket');
    }
    public function item(){
        return $this->belongsTo('App\ItemModel','item');
    }
}
