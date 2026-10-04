<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['stock'])->get();
        return TransactionResource::collection($transactions);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'barang_id' => 'required|exists:stocks,id',
            'tipe_transaksi' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
        ]);

        $transaction = Transaction::create($validatedData);

        return new TransactionResource($transaction);
    }
    
    public function update(Request $request, Transaction $transaction)
    {
        $validatedData = $request->validate([
            'barang_id' => 'required|exists:stocks,id',
            'tipe_transaksi' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
        ]);

        $transaction->update($validatedData);

        return new TransactionResource($transaction);
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('stock');
        return new TransactionResource($transaction);
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return response()->json(['message' => 'Transaction deleted successfully']);
    }
}
