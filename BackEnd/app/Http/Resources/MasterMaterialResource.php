<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterMaterialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'materialID'            => $this->id,
            'materialCode'          => $this->kdbarang,
            'materialDescription'   => $this->namabarang,
            'materialPrice'         => $this->harga,
        ];
    }
}
