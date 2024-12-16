<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class UserResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'provinsi' => $this->provinsi,
            'kota' => $this->kota,
            'alamat' => $this->alamat,
            'date_of_birth' => $this->date_of_birth,
            'token'=>$this->whenNotNull($this->token),
        ];
    }
}
