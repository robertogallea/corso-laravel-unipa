<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Product;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    //
    public function index()
    {
        $movements = Movement::withSum('products as total_qty', 'movement_product.qty')
            ->withTotalPrice()
            ->get();

        return view('movements.index', compact('movements'));
    }
}
