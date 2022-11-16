<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RequestModel;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
    }

    public function getcount(){
        return  RequestModel::where('status','approved')->count();
    }

    public function getcountchiefstore(){
        return  RequestModel::where('status','open')->orWhere('status','rejected')->count();
    }
    public function getcountrnd(){
        return  RequestModel::where('status','waiting rnd')->count();
    }
    public function getcountinfra(){
        return  RequestModel::where('status','waiting infra')->count();
    }
}
