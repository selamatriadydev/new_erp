<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = "sales";
    protected $fillable = ['id','code_sales','id_card','nama_sales','no_hp','alamat','ktp'];
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
