<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'userId'              => $this->id,
            'userName'            => $this->name,
            'userUsername'        => $this->username,
            'userEmail'           => $this->email,
            'userEmailVerifiedAt' => $this->email_verified_at,
            'userRememberToken'   => $this->remember_token,
            'userCreatedAt'       => $this->created_at,
            'userUpdatedAt'       => $this->updated_at,
        ];
    }
}
