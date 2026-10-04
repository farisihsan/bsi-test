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

    public function update(Request $request, Stock $stock)
    {
        $validatedData = $request->validate([
            'kode_barang' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:categories,id',
            'satuan' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
        ]);

        $stock->update($validatedData);

        return new StockResource($stock);
    }
    public function show(Stock $stock)
    {
        $stock->load('category', 'transactions');
        return new StockResource($stock);
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return response()->json(['message' => 'Stock deleted successfully']);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_barang' => 'required|string|max:255|unique:stocks,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:categories,id',
            'satuan' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
        ]);

        $stock = Stock::create($validatedData);

        return new StockResource($stock);
    }
}
