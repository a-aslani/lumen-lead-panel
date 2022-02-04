<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Lead extends Model {

    protected $fillable = [
        "first_name",
        "last_name",
        "phone",
        "email",
        "token",
        "crm_name",
        "landing_url",
        "added_to_crm",
        "error_message",
        "register_api_url"
    ];
}
