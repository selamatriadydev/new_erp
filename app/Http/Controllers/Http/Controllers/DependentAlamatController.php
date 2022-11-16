<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provinces;
use App\Regencies;
use App\Disctricts;
use App\Villages;
class DependentAlamatController extends Controller
{
    
    public function getKecamatan(Request $request){
        $kecamatan = Disctricts::where("regency_id",$request->kabID)->pluck('id','name');
        return response()->json($kecamatan);
    }
    public function getDesa(Request $request){
        $desa = Villages::where("district_id",$request->kecID)->pluck('id','name');
        return response()->json($desa);
    }
}
