<?php

namespace App\Exports;

use App\RequestModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class Requestall implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.export', [
            'export' => RequestModel::with('rel_akibat','rel_penyebab')->get()
        ]);
    }
}
