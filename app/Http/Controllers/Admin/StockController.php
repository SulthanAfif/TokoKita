<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')
            ->withSum(['orderItems as sold_qty' => function ($q) {
                $q->whereHas('order', fn ($o) => $o->where('status', '!=', 'cancelled'));
            }], 'quantity');

        // Filter stok
        if ($request->filter === 'low') {
            $query->where('stock', '<=', 5);
        } elseif ($request->filter === 'medium') {
            $query->whereBetween('stock', [6, 20]);
        } elseif ($request->filter === 'ok') {
            $query->where('stock', '>', 20);
        } elseif ($request->filter === 'empty') {
            $query->where('stock', '<=', 0);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->orderBy('stock')->paginate(20)->withQueryString();

        $summary = [
            'total_stock' => Product::sum('stock'),
            'total_products' => Product::count(),
            'empty' => Product::where('stock', '<=', 0)->count(),
            'low' => Product::where('stock', '>', 0)->where('stock', '<=', 5)->count(),
            'medium' => Product::whereBetween('stock', [6, 20])->count(),
            'ok' => Product::where('stock', '>', 20)->count(),
        ];

        return view('admin.stock.index', compact('products', 'summary'));
    }
}
