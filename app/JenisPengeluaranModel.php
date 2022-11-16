<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisPengeluaranModel extends Model
{
    protected $table = "jenis_pengeluaran_models";
    protected $fillable = ['nama_pengeluaran','cabang_id','hak_akses'];

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
