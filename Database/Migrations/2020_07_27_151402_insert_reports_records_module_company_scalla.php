<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Modules\Dashboard\Repositories\ReportRepository;

class InsertReportsRecordsModuleCompanyScalla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ReportRepository::newByCategory(['module' => 'CompanyScalla', 'export' => 'ProductsExport', 'alias' => 'Scalla - Pós Feira'], 'Produtos');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        ReportRepository::deleteByAlias('Scalla - Pós Feira');
    }
}
