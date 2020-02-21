<?php

namespace Modules\CompanyScalla\Imports;


use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Events\BeforeImport;

use Modules\Client\Events\BeforeImportEvent;
use Modules\Client\Events\AfterImportEvent;

use Exception;

class FileImport implements OnEachRow, WithHeadingRow, WithEvents
{

	use Importable, RegistersEventListeners;

	private $cells;

	public function onRow(Row $row)
	{
		
	}

	public static function beforeImport(BeforeImport $event)
	{
		$cells = $event->getDelegate()->getActiveSheet()->toArray();
		$import = $event->getConcernable();
		$import->setCells($cells);
	}

	public function setCells($cells)
	{
		$this->cells = $cells;
	}

	public function data()
	{
		return $this->cells;
	}

}
