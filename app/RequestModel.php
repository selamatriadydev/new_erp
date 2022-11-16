<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestModel extends Model
{
    protected $table = "request";
    protected $fillable = ['no_req','pelapor','cabang_id','spk','penyebab','permintaan','akibat',
                            'status','aktor','proseshelp','prosesrnd','metode','lampiran','reasonreject','chiefstore','rejectchiefstore','tgl_rejected','dll_penyebab','dll_akibat','tgl_close','tgl_solved',
                            'tgl_approved'];

    public function cabang(){
        return $this->belongsTo('App\CabangModel');
    }

    public function rel_akibat(){
        return $this->belongsTo('App\AkibatModel','akibat');
    }

    public function rel_penyebab(){
        return $this->belongsTo('App\PenyebabModel','penyebab');
    }
}
