<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;

class LeadsController extends Controller
{
  
  public function index() {
    
    return View("leads.home");
  }
  
  public function stats() {
    $data['stats'] = Lead::get();
    
    return View("leads.leadsstats",$data);
  }
  
  
  
  
}
