<?php

namespace App\Http\Controllers\v2;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends \App\Http\Controllers\Controller
{
    public function store(Request $request)
    {

        $this->validate($request, [
            'last_name' => 'required',
            'email' => 'required|email|unique:leads',
            'token' => 'required',
            'register_api_url' => 'required',
        ]);

        Lead::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'token' => $request->input('token'),
            'crm_name' => $request->input('crm_name'),
            'landing_url' => $request->input('landing_url'),
            'register_api_url' => $request->input('register_api_url'),
        ]);

        return response()->json([
            "message" => "successfully",
        ]);
    }
}
