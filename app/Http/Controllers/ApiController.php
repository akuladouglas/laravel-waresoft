<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;
use App\Models\SmsLead;


class ApiController extends BaseController
{
  
  function shortCodeCallback()
  {

    mail("akulad19@gmail.com","I was hit now at BC Server !","to do :");
    
    $smsLead = new SmsLead();
    $smsLead->text = $json_string;
    $smsLead->save();

    /*
    $smsLead = new SmsLead();
    $smsLead->sms_to = $request->input("to");
    $smsLead->sms_from = $request->input("from");
    $smsLead->created_at = $request->input("date");
    $smsLead->text = $request->input("text");
    $smsLead->link_id = $request->input("linkId");
    $smsLead->sms_id = $request->input("id");
    $smsLead->save();
    */

  }
    
}