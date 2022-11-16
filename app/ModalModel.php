<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModalModel extends Model
{
    protected $table = "modal_models";
    protected $fillable = ['nama_pemodal','nominal'];

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
