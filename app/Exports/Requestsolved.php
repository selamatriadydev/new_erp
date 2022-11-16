<?php

namespace App\Exports;

use App\RequestModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class Requestsolved implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.export', [
            'export' => RequestModel::where('status','solved')->with('rel_akibat','rel_penyebab')->get()
        ]);
    }
}
