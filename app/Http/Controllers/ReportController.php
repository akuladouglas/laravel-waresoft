<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
  
  function getReports() {
      $data[] = '';
      
      return view("reports/home", $data);
    }
    
}
