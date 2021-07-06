<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'wallet_from' => $this->wallet_from,
            'wallet_to' => $this->wallet_to,
            'status' => $this->status,
            'total' => (int) $this->total,
            'gateway_code' => $this->gateway_code
        ];
    }
}