<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

/**
 * Description of PaymentService
 *
 * @author epic-code
 */
class PaymentService {
  //put your code here
  
  private $sandbox_url = "https://sandbox.safaricom.co.ke/oauth/v1/";
  private $live_url = "";
  private $initiator = "";
  private $sandbox_consumer_key =  "Pfji5yLpcejTKhpaOk1X3W5MHiaGANVV"; //"sVW4cxBpsy28nG53hiZaJaI6cYBHTw9j"; //"j29xEwhkGImBrL8FSjcYJ9gO56g4B2A2"; //
  private $sandbox_consumer_secret = "J9t4fr4WPaLuzBZq"; //"rOH7SQETF162A69b"; // "RzgsAxAc3ueAbS6y"; //


  function generateToken($debug = false) {

    $url = "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
    
    //$url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    $credentials = base64_encode($this->sandbox_consumer_key . ":" . $this->sandbox_consumer_secret);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials)); //setting a custom header
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $curl_response = curl_exec($curl);

    $results = json_decode($curl_response);
    
    if($debug){
      
      echo "<pre>";
      print_r($results);
      echo "</pre>";
      exit();
      
    }
    
    return ($results->access_token);
    
  }

  function securityCredential($debug = false) {

    $cert_directory = base_path()."/certs/production_cert.cer"; // "certs/production_cert.cer"
    $plaintext = "Comp1988uter!"; //"H@rdpa55w0rds"
    
    $fp=fopen($cert_directory,"r"); 
    $publicKey=fread($fp,8192); 
    fclose($fp); 

    $success = openssl_public_encrypt($plaintext, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);

    $results = base64_encode($encrypted);
    
    if($debug){
      
      echo "<pre>: success: ";
      print_r($cert_directory);
      echo "</pre>";
      
      echo "<pre>: success: ";
      print_r($success);
      echo "</pre>";
      
      echo "<pre> results: ";
      print_r($results);
      echo "</pre>";
      
      exit();
      
    }
    
    return $results;
    
  }

  
  function registerUrl() {
    
    $url = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';

    //$url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';

    $access_token = $this->generateToken();
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Authorization:Bearer $access_token")); //setting custom header
	
    $curl_post_data = array(
      //Fill in the request parameters with valid values
      'ShortCode' => '638620',
      'ResponseType' => 'Completed',
      'ConfirmationURL' => "https://beauty.click/cportal/index.php/paybill/confirmPayment",
      'ValidationURL' => "https://beauty.click/cportal/index.php/paybill/validateRequest"
    );
		

    $curl_post_data_x = array(
      //Fill in the request parameters with valid values
      'ShortCode' => '638620',
      'ResponseType' => 'Completed',
      'ConfirmationURL' => "http://beauty.click/cportal/index.php/paybill/confirmTestPayment",
      'ValidationURL' => "http://beauty.click/cportal/index.php/paybill/validateTestRequest"
    );

    $data_string = json_encode($curl_post_data);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

    $curl_response = curl_exec($curl);
    print_r($curl_response);

    echo $curl_response;
    
  }
  
  
  function simulateTransaction() {
    
    //$url = 'https://api.safaricom.co.ke/mpesa/c2b/v1/simulate';

    $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';

    $access_token = $this->generateToken();
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Authorization:Bearer $access_token")); //setting custom header

    $curl_post_data = array(
            //Fill in the request parameters with valid values
           'ShortCode' => '638620',
           'CommandID' => 'CustomerPayBillOnline',
           'Amount' => '100',
           'Msisdn' => '254721869246',
           'BillRefNumber' => '12893'
    );

    $data_string = json_encode($curl_post_data);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

    $curl_response = curl_exec($curl);
    print_r($curl_response);

    echo $curl_response;
    
  }
  
  
  function sendSTK($phone_number, $amount, $account_number) {
    
    $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    
    //$url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    
    //password = base64.encode(ShortcodePasskeyTimestamp)
    
    
    $shortcode = 638620;
    $timestamp = date("YmdHis", time());
    $passkey = "100883e086d9703839a069dac12a860416d8f9d9686ea6472e66507a537c5dff";
    $shortcodePasskeyTimestamp = $shortcode.$passkey.$timestamp;

    $password = base64_encode($shortcodePasskeyTimestamp);

    $access_token = $this->generateToken();
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Authorization:Bearer $access_token"));

    $curl_post_data = array(
      //Fill in the request parameters with valid values
      'BusinessShortCode' => '638620',
      'Password' => $password,
      'Timestamp' => $timestamp, //date("Ymdhms"),
      'TransactionType' => 'CustomerPayBillOnline',
      'Amount' => $amount,
      'PartyA' => $phone_number,
      'PartyB' => '638620',
      'PhoneNumber' => $phone_number,
      'CallBackURL' => 'https://beauty.click/cportal/index.php/paybill/confirmTestPayment',
      'AccountReference' => $account_number,
      'TransactionDesc' => 'Test'
    );
    
    $data_string = json_encode($curl_post_data);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

    $curl_response = curl_exec($curl);
    
  }
  
  
  function postTransaction() {
    
    $securityCredential = $this->securityCredential();
    
    $access_token = $this->generateToken();
    
    $url = "https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest";
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Authorization:Bearer $access_token")); //setting custom header


    $curl_post_data = array(
      //Fill in the request parameters with valid values
      'InitiatorName' => "apiinitiator",
      'SecurityCredential' => $securityCredential,
      'CommandID' => 'SalaryPayment',
      'Amount' => '100',
      'PartyA' => '654221',
      'PartyB' => '254721869246',
      'Remarks' => 'Test Transaction',
      'QueueTimeOutURL' => 'https://minuteflash.com',
      'ResultURL' => 'https://minuteflash.com',
      'Occasion' => ' '
    );

    $data_string = json_encode($curl_post_data);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

    $curl_response = curl_exec($curl);
    
    print_r($curl_response);

  }

}
