<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterMemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'memberID'          => $this->id,
            'memberCode'        => $this->kode,
            'memberName'        => $this->nama,
            'memberBirthdate'   => $this->tgllahir,
            'memberSex'         => $this->jnskelamin,
            'memberAddress'     => $this->alamat,
            'memberCity'        => $this->kota,
            'memberProvince'    => $this->provinsi,
            'memberEmail'    => $this->email,
            'memberPhone'    => $this->no_hp,

        ];
    }
}
