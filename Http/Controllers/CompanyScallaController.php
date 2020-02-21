<?php

namespace Modules\CompanyScalla\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\CompanyScalla\Imports\FileImport;
use Modules\CompanyScalla\Exports\FileExport;
use Maatwebsite\Excel\Facades\Excel;

class CompanyScallaController extends Controller
{

    public function index()
    {
        return view('companyscalla::index');
    }

    public function file()
    {
        $excel = new FileImport();
        $excel->import('scalla/abcasa.xlsx');

        $abcasa = $excel->data();
        array_shift($abcasa);
        //$abcasa = array_slice($abcasa, 0, 100);

        $excel = new FileImport();
        $excel->import('scalla/abup.xlsx');

        $abup = $excel->data();        
        array_shift($abup);
        //$abup = array_slice($abup, 0, 100);
        //dd($abup);

        $abcasa_abup = [['linha', 'referencia', 'descrição', 'quantidade']];
        foreach ($abcasa as $i => $row_abcasa) {
            $flag = true;

            foreach ($abup as $y => $row_abup) {
                $sku_abcasa = $row_abcasa[0].'-'.$row_abcasa[1];
                $sku_abup = $row_abup[0].'-'.$row_abup[1];                
                if($sku_abcasa == $sku_abup)
                {
                    $new_row = [
                        $row_abcasa[0],
                        $row_abcasa[1],
                        $row_abcasa[2],
                        $row_abcasa[3]+$row_abup[3]  
                    ];
                    array_push($abcasa_abup, $new_row);
                    $flag = false;
                }
            }
            if($flag)
            {
                array_push($abcasa_abup, $row_abcasa);
            }
        }

        $abup_rows = [];
        foreach ($abup as $y => $row_abup) {
            $flag = true;
            foreach ($abcasa_abup as $i => $row_abcasa_abup) {
                $sku_abcasa_abup = $row_abcasa_abup[0].'-'.$row_abcasa_abup[1];
                $sku_abup = $row_abup[0].'-'.$row_abup[1];
                if($sku_abcasa_abup == $sku_abup)
                {
                    $flag = false;
                }
            }
            if($flag)
            {
                array_push($abup_rows, $row_abup);
            }            
        }

        //dd($abup_rows);
        foreach ($abup_rows as $row_abup) {
                array_push($abcasa_abup, $row_abup);
        }


        //dd($abcasa_abup);
        return Excel::download(new FileExport($abcasa_abup), 'Scalla.xlsx');
    }

}
