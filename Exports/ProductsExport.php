<?php 
namespace Modules\CompanyScalla\Exports;

use Modules\Product\Repositories\ProductRepository;
use Modules\Order\Repositories\ItemRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ProductsExport implements FromCollection, WithStrictNullComparison
{
    public function collection()
    {
        return new Collection($this->data());
    }


    private function data(){
    	return array_merge($this->header(), $this->body());
    }

    private function header(){
    	return [['linha', 'referencia', 'descricao', 'quantidade']];
    }


    private function body(){
        $products = ProductRepository::loadAll();
        $body = [];

        foreach ($products as $product) {
            $row = (object) [
                'linha' => $this->linha($product),
                'referencia' => $this->referencia($product),
                'descricao' => $this->descricao($product),
                'quantidade' => 0,
            ];

            $items = ItemRepository::loadSoldItemsByProduct($product);

            foreach ($items as $item) {
                $row->quantidade += $item->qty;
            }

            array_push($body, $row);
        }

        return (new Collection($body))->sortByDesc('total')->toArray();

    }

    private function linha($product)
    {
        return (explode('-', $product->sku))[0];
    }

    private function referencia($product)
    {
        if(isset((explode('-', $product->sku))[1]))
        {
            return (explode('-', $product->sku))[1];
        } else 
        {
            return (explode('-', $product->sku))[0];
        }

    }

    private function descricao($product)
    {
        return $product->description;
    }

}