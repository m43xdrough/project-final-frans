<?php

namespace App\Http\Resources;

use App\Models\TransResep;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransSOHResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'soID'          => $this->id,
            'soTransNo'        => $this->notrans,
            'soTransDate'        => $this->tgltrans,
            'soSubtotal'   => $this->subtotal,
            'soTotalDisc'         => $this->totdisc,
            'soTotalPPN'     => $this->totppn,
            'soGrandTotal'        => $this->grandtotal,
            'soReceipt_Id' => $this->resep_id,
            'receipt'    => new TransResepResource(TransResep::find($this->resep_id)),
            'transdetail'    => TransSODResource::collection($this->transdetail),


        ];
    }
}
