<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;
use App\Models\SmsLead;
use Carbon\Carbon;
use App\Helpers\SmsRedemptions;
use App\Services\SmsService;

class ApiController extends BaseController
{
 
  function test() {
    $smsRedemptionsHelper = new SmsRedemptions();
    $smsRedemptionsHelper->redeemLoyaltyPoints();
  }
  
  function shortCodeCallback()
  {
    $linkId = $_POST["linkId"];
    $text = strtolower($_POST["text"]);
    $to = $_POST["to"];
    $id = $_POST["id"];
    $date = Carbon::parse($_POST["date"])->format("Y-m-d h:m:s");
    $from = $_POST["from"];
    
    if (strpos($text, 'offers') !== false || strpos($text, 'offers') !== false || strpos($text, 'offering') !== false ) {
       $smsRedemption = new SmsRedemptions();
       $smsRedemption->offerInfo($from);
    }
    
    if (strpos($text, 'claim') !== false || strpos($text, 'claiming') !== false) {
       $smsRedemption = new SmsRedemptions();
       $smsRedemption->redeemPoints($from, $text);
    }
    
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