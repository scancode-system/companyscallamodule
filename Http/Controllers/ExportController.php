<?php

namespace Modules\CompanyScalla\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\CompanyScalla\Services\TxtOrderService;

class ExportController extends Controller
{

    public function txtOrders(Request $request)
    {
        $txt =  new TxtOrderService();
        $txt->run();
        return $txt->download();
    }

}