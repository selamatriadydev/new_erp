<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SatuanModel extends Model
{
    protected $table = "satuan_models";
    protected $fillable = ["nama_satuan"];
    public $timestamps = false;
    public function user(){
        return $this->hasOne('App\User');
    }
    public function order(){
        return $this->hasOne('App\OrderModel');
    }
    public function cart(){
        return $this->hasOne('App\CartModel');
    }
    public function paket(){
        return $this->hasOne('App\PaketModel');
    }
    public function Item(){
        return $this->hasOne('App\ItemModel');
    }
    public function Iteminv(){
        return $this->hasOne('App\IteminvModel');
    }
    public function request(){
        return $this->hasOne('App\RequestModel');
    }
}
