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

    public function show(Transaction $transaction)
    {
        $transaction->load('stock');
        return new TransactionResource($transaction);
    }
}
