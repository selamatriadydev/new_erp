<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IntiKomposisiModel extends Model
{
    protected $table = "inti_komposisi_models";
    protected $fillable = ['id_resep','hpp'];

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
