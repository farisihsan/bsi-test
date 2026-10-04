<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'barang_id' => $this->barang_id,
            'tipe_transaksi' => $this->tipe_transaksi,
            'jumlah' => $this->jumlah,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'stock' => new StockResource($this->whenLoaded('stock')),
        ];
    }
}
