<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kode_barang' => $this->kode_barang,
            'nama_barang' => $this->nama_barang,
            'slug' => $this->slug,
            'kategori_id' => $this->kategori_id,
            'satuan' => $this->satuan,
            'stok' => $this->stok,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'transactions' => TransactionResource::collection($this->whenLoaded('transactions')),
        ];
    }
}
