<?php

namespace Modules\CompanyScalla\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Order\Repositories\OrderRepository;
use  ZipArchive;

class TxtOrderService 
{

	public function run()
	{
		Storage::deleteDirectory('txt-scalla');

		$orders = OrderRepository::loadClosedOrders();
		foreach ($orders as $order) 
		{
			$file_orders_path = 'txt-scalla/pedidos.txt';
			$file_items_path = 'txt-scalla/pedidositens.txt';

			$this->header($file_orders_path, $order);

			foreach ($order->items as $item) 
			{				
				$this->item($file_items_path, $item);
			}
		}

		$this->zip();
		Storage::deleteDirectory('txt-scalla');
	}

	private function header($file_path, $order)
	{
		$shipping_company_id = $order->order_shipping_company->shipping_company_id;

		Storage::append($file_path, 
			mb_substr(addString($order->id, 10, '0'), 0, 10).
			mb_substr(addString($order->order_saller->saller_id, 4, '0'), 0, 4).
			mb_substr($order->closing_date, 0, 4).
			mb_substr($order->closing_date, 5, 2).
			mb_substr($order->closing_date, 8, 2).
			mb_substr($order->closing_date, 11, 2). 
			mb_substr($order->closing_date, 14, 2).
			mb_substr($order->closing_date, 17, 2).

			mb_substr($order->closing_date, 0, 4).
			mb_substr($order->closing_date, 5, 2).
			mb_substr($order->closing_date, 8, 2).
			mb_substr($order->closing_date, 11, 2). 
			mb_substr($order->closing_date, 14, 2).
			mb_substr($order->closing_date, 17, 2).

			mb_substr(addString($order->order_client->client_id, 6, '0'), 0, 6).
			mb_substr(addString($order->order_payment->payment_id, 4, '0'), 0, 4).
			mb_substr(addString($order->order_shipping_company->shipping_company_id, 6, ' ', false), 0, 6).
			mb_substr(addString(number_format(($order->total/2), 2, '', ''), 20, '0'), 0, 20));
	}

	private function item($file_path, $item)
	{
		$tax_ipi = $item->item_taxes()->where('module', 'ipi')->first();
		if($tax_ipi)
		{
			$ipi = $tax_ipi->porcentage;
			$ipi_value = $tax_ipi->value;
		}else
		{
			$ipi = 0;
			$ipi_value = 0;
		}

		Storage::append($file_path, 
			mb_substr(addString($item->order->id, 10, '0'), 0, 10).
			mb_substr(addString($item->product->barcode, 20, ' ', false), 0, 20). 
			mb_substr(addString($item->qty, 10, '0'), 0, 10).
			mb_substr(addString(number_format($item->price, 2, '', ''), 10, '0'), 0, 10).

			mb_substr(addString(number_format($item->discount_value, 2, '', ''), 10, '0'), 0, 10).
			mb_substr(addString(number_format($item->addition_value, 2, '', ''), 10, '0'), 0, 10).

			mb_substr(addString(number_format($item->total, 2, '', ''), 20, '0'), 0, 20).
			mb_substr(addString(number_format($ipi, 2, '', ''), 4, '0'), 0, 4).
			mb_substr(addString(number_format($ipi_value, 2, '', ''), 10, '0'), 0, 10));
	}


	public function zip()
	{
		$files = Storage::allFiles('txt-scalla');
		$zip_path = storage_path('app/txt-scalla.zip'); 
		$zip = new ZipArchive;
		$zip->open($zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE);
		foreach ($files as $file) {
			$zip->addFile(storage_path('app/'.$file), $file);
		}
		$zip->close();
	}	

	private function file_path($order)
	{
		return 'txt-scalla/'.mb_substr(addString($order->id, 7, '0'), 0, 7). '.txt';
	}


	public function download()
	{
		return response()->download(storage_path('app/txt-scalla.zip'))->deleteFileAfterSend();;
	}

}