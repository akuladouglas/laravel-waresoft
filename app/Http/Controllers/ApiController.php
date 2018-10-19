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
    $json_string = ($_POST);

    mail("akulad19@gmail.com","I was hit now at BC Server !","to do :");
    
    $linkId = $json_string['linkId'];
    $text = $json_string['text'];
    $to = $json_string['to'];
    $id = $json_string['id'];
    $date = Carbon::parse($json_string['date'])->format("Y-m-d h:m:s");
    $from = $json_string['from'];

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