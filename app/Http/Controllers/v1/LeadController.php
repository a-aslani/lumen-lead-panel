<?php

namespace App\Http\Controllers\v1;

use App\Exports\LeadsExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\LeadCollection;
use App\Models\Lead;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $start = "";
        $end = "";

        if (!empty($request->start_date)) {
            $start = $request->start_date;
        }
        if (!empty($request->end_date)) {
            $end = $request->end_date;
        }

        if ($start == "" || $end == "") {
            $leads = Lead::orderBy("id", "DESC")->paginate(15);
        } else {
            $leads = Lead::whereDate('created_at', '<=', $end)->whereDate('created_at', '>=', $start)->orderBy("id", "DESC")->paginate(15);
        }

        return new LeadCollection($leads);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'last_name' => 'required',
            'email' => 'required|email',
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

    public function search(Request $request, $token)
    {

        $start = "";
        $end = "";

        if (!empty($request->start_date)) {
            $start = $request->start_date;
        }
        if (!empty($request->end_date)) {
            $end = $request->end_date;
        }

        if ($start == "" || $end == "") {
            $leads = Lead::where('token', $token)->orderBy("id", "DESC")->paginate(15);
        } else {
            $leads = Lead::where('token', $token)->whereDate('created_at', '<=', $end)->whereDate('created_at', '>=', $start)->orderBy("id", "DESC")->paginate(15);
        }

        return new LeadCollection($leads);
    }

    public function exportLeads(Request $request)
    {

        $start = "";
        $end = "";
        if (!empty($request->start_date)) {
            $start = $request->start_date;
        }
        if (!empty($request->end_date)) {
            $end = $request->end_date;
        }

        $token = $request->input('token');

        $leads[] = ['firstName', 'lastName', 'phone', 'email', 'country'];

        if ($start == "" || $end == "") {
            if ($token) {
                $newLeads = Lead::where('token', $token)->get()->toArray();
            } else {
                $newLeads = Lead::get()->toArray();
            }

        } else {
            if ($token) {
                $newLeads = Lead::where('token', $token)->whereDate('created_at', '<=', $end)->whereDate('created_at', '>=', $start)->get()->toArray();
            } else {
                $newLeads = Lead::whereDate('created_at', '<=', $end)->whereDate('created_at', '>=', $start)->get()->toArray();
            }
        }

        foreach ($newLeads as $key => $value) {
            unset($newLeads[$key]['id']);
            unset($newLeads[$key]['token']);
            unset($newLeads[$key]['created_at']);
            unset($newLeads[$key]['updated_at']);
            unset($newLeads[$key]['crm_name']);
            unset($newLeads[$key]['landing_url']);
            unset($newLeads[$key]['added_to_crm']);
            unset($newLeads[$key]['error_message']);
            unset($newLeads[$key]['register_api_url']);
            $newLeads[$key][] = "IR";
        }

        $leads[] = $newLeads;

        return Excel::download(new LeadsExport($leads), 'leads.csv');
    }


    public function updateLead(Request $request, $id) {
        $this->validate($request, [
            'register_api_url' => 'required',
            'added_to_crm' => 'required',
        ]);

        $lead = Lead::find($id);
        $lead->update([
            'added_to_crm' => $request->input('added_to_crm'),
            'error_message' => $request->input('error_message'),
        ]);

        return response()->json([
            "message" => "successfully",
            "lead"=> new \App\Http\Resources\v1\Lead($lead),
        ]);
    }

}
