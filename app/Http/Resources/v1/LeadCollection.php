<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LeadCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return [
            "data" => $this->collection->map(function ($item) {
                return [
                    "id" => $item->id,
                    "first_name" => $item->first_name,
                    "last_name" => $item->last_name,
                    "phone" => $item->phone,
                    "email" => $item->email,
                    "created_at" => $item->created_at->format('Y-m-d H:i:s'),
                    "token" => $item->token,
                    "crm_name" => $item->crm_name,
                    "landing_url" => $item->landing_url,
                    "is_new" => !$item->added_to_crm,
                    "error_message" => $item->error_message,
                    "register_api_url" => $item->register_api_url,
                ];
            }),
        ];
    }

}
