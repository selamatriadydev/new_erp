<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaketModel extends Model
{
    protected $table = "paket_models";
    protected $fillable = ['code_paket','nama_paket','jenis_paket','hpp','harga_jual','code_komponen','gambar','cabang_id'];

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
