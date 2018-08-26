<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use Validator;
use Auth;

class LeadsController extends Controller {

  public function index() {

    return View("leads.home");
  }

  public function stats() {
    $data['stats'] = Lead::get();

    return View("leads.leadsstats", $data);
  }

  public function add() {
    $data[''] = "";

    return View("leads.add", $data);
  }

  public function processAdd(Request $request) {

    $validation_rules = [
      
    ];

    $lead = new Lead();
    $lead->user_id = Auth::id();
    $lead->save();
    
    $request->session()->flash("success", "Lead added successfully");
    
    return redirect(url("leads"));
    
  }
  

}
