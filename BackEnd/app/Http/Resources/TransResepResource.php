<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransResepResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'receiptID'         => $this->id,
            'receiptNumber'     => $this->noresep,
            'receiptDate'       => $this->tglresep,
            'receiptSpherisr'   => $this->chspherisr,
            'receiptSpherisl'   => $this->chspherisl,
            'receiptCylinderr'  => $this->chcylinderr,
            'receiptCylinderl'  => $this->chcylinderl,
            'receiptAdditionr'  => $this->chadditionr,
            'receiptAdditionl'  => $this->chadditionl,
            'receiptAxisr'      => $this->chaxisr,
            'receiptAxisl'      => $this->chaxisl,
            'receiptMemberID'   => $this->member_id,
            'member'            => new MasterMemberResource($this->member)

        ];
    }
}
