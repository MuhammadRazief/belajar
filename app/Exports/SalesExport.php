<?php

namespace App\Exports;

use App\Models\Detail_sales;
use App\Models\Sales;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalesExport implements FromView
{

    public function view(): View
    {
        
        return view('views.excel.sale', ['sales' => Sales::all(),'detail_sale'=> Detail_sales::all()]);
    }
}
