<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class Lead extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "phone" => $this->phone,
            "email" => $this->email,
            "created_at" => $this->created_at->format('Y-m-d H:i:s'),
            "token" => $this->token,
            "crm_name" => $this->crm_name,
            "landing_url" => $this->landing_url,
            "is_new" => !$this->added_to_crm,
            "error_message" => $this->error_message,
            "register_api_url" => $this->register_api_url,
        ];
    }
}
