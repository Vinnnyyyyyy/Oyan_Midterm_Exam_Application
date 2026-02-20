<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = [
            [
                'id'    => 1,
                'name'  => 'Laptop',
                'price' => 49999.00,
                'stock' => 10,
            ],
            [
                'id'    => 2,
                'name'  => 'Wireless Mouse',
                'price' => 1299.00,
                'stock' => 50,
            ],
            [
                'id'    => 3,
                'name'  => 'Mechanical Keyboard',
                'price' => 3499.00,
                'stock' => 25,
            ],
            [
                'id'    => 4,
                'name'  => 'Monitor',
                'price' => 15999.00,
                'stock' => 8,
            ],
            [
                'id'    => 5,
                'name'  => 'USB-C Hub',
                'price' => 2199.00,
                'stock' => 30,
            ],
        ];

        return view('products.index', compact('products'));
    }
}