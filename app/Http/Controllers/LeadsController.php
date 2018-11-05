<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmsLead;
use Validator;
use Auth;
use Carbon\Carbon;

class LeadsController extends Controller {

  public function index() {
    $data['stats'] = SmsLead::where('text', 'not like', '%' . 'redeem' . '%')->get();
    return View("leads.home", $data);
  }

  public function stats() {
    $data['stats'] = SmsLead::get();

    return View("leads.leadsstats", $data);
  }

  public function add() {
    $data["interested_reasons"] = [
      "Human Hair Weave",
      "Human hair Wig",
      "Synthetic Weave",
      "Synthetic Wig",
      "Braids/Crochet Locs",
      "Maybelline",
      "Nouba",
      "Revlon",
      "Note",
      "Other",
    ];
    return View("leads.add", $data);
  }

  public function processAdd(Request $request) {

    $validation_rules = [
      
    ];

    $lead = new Lead();
    $lead->user_id = Auth::id();
    $lead->created_at = Carbon::now()->format("Y-m-d");
    $lead->client_name = $request->input("client_name");
    $lead->client_phone = $request->input("client_phone");
    $lead->client_facebook_name = $request->input("client_facebook_name");
    $lead->interested_in = $request->input("interested_in");
    
    $lead->save();
    
    $request->session()->flash("success", "Lead added successfully");
    
    return redirect(url("leads"));
    
  }
  
  public function markConverted($smslead_id, Request $request) {
    
    $lead = SmsLead::where("smslead_id",$smslead_id)->get()->first();
    $lead->converted = 1;
    $lead->save();
    
    $request->session()->flash("success","Sms Lead updated successfully"); 
     
    return redirect(url("leads"));
    
  }
  

}
