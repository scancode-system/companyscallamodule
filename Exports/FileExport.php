<?php 
namespace Modules\CompanyScalla\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class FileExport implements FromCollection, WithStrictNullComparison
{

    private $cells;

    public function __construct($cells) {
        $this->cells = $cells;
    }

    public function collection()
    {
        return new Collection($this->cells);
    }



}