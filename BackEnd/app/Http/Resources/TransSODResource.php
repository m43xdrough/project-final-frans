<?php

namespace App\Http\Resources;

use App\Models\MasterMaterial;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransSODResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $material = MasterMaterial::find($this->material_id);
        return [
            'itemID'          => $this->id,
            'itemNo'          => $this->nourut,
            'itemCode'        => $material->kdbarang,
            'itemDescription'   => $material->namabarang,
            'itemPrice'         => $this->harga,
            'itemQty'         => $this->qty,
            'itemDisc'         => $this->disc,
            'itemNDisc'         => $this->ndisc,
            'itemPPN'         => $this->ppn,
            'itemNPPN'         => $this->nppn,
            'itemTotal'         => $this->total,
        ];
    }
}
