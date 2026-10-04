<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\StockResource;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = Stock::with(['category'])->get();
        return StockResource::collection($stocks);
    }

    public function show(Stock $stock)
    {
        $stock->load('category', 'transactions');
        return new StockResource($stock);
    }

}
