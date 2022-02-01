<?php

namespace App\Services;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function paginatedProducts()
    {
        return Product::paginate(10);
    }

    public function saveProduct($data)
    {
        return Product::updateOrCreate(
            [ 'id' => $data['product_id'] ],
            [
                'name'  => $data['name'],
                'price' => $data['price'] * 100
            ]
        );
    }

    public function purchaseProducts($products)
    {
        $buyer = Auth::user();

        foreach ($products as $product) {
            $buyer->purchased()->attach($product['product_id'], [
                'quantity'      => $product['quantity'],
                'amount'        => $product['amount']
            ]);
        }
    }

    public function dateReport($date)
    {
        $date = Carbon::parse($date);

        return DB::table('products')
                ->join('reports', 'products.id', '=', 'reports.product_id')
                ->whereDate('reports.created_at', $date)
                ->join('report_views', 'products.id', '=', 'report_views.product_id')
                ->whereDate('report_views.created_at', $date)
                ->selectRaw('products.id, products.name, SUM(distinct(report_views.views)) as views, SUM(reports.amount) as amount')
                ->groupBy('products.id')
                ->get();
    }
}
