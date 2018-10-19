<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;
use App\Models\SmsLead;
use Carbon\Carbon;


class ApiController extends BaseController
{
  
  function shortCodeCallback()
  {
    
    $linkId = $_POST['linkId'];
    $text = $_POST['text'];
    $to = $_POST['to'];
    $id = $_POST['id'];
    $date = Carbon::parse($_POST['date'])->format("Y-m-d h:m:s");
    $from = $_POST['from'];
    
    $smsLead = new SmsLead();
    $smsLead->sms_to = $to;
    $smsLead->sms_from = $from;
    $smsLead->created_at = $date;
    $smsLead->text = $text;
    $smsLead->link_id = $linkId;
    $smsLead->sms_id = $id;
    $smsLead->save();

  }
    
}