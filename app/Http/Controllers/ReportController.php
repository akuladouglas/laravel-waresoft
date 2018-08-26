<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
  
    public function getReports()
    {
        $data[] = '';
      
        return view("reports/home", $data);
    }
    
    public function getVendorReports()
    {
        $data[] = '';
      
        return view("reports/vendor", $data);
    }
    
}
