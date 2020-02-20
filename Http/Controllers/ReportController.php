<?php

namespace Modules\CompanyScalla\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\CompanyScalla\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    public function products()
    {
        return Excel::download(new ProductsExport, 'Produtos Scalla.xlsx');
    }

}
