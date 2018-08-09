<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

/**
 * Description of SmsService
 *
 * @author epic-code
 */
class SmsService {

    private $token;
    private $user_id;
    private $timestamp;

    function __construct() {
        $this->token = md5("beauty123");
        $this->user_id = "676";
        $this->timestamp = time();
    }

    function getUnsendSms($limit = 5) {

        $results = array();

        $this->db->order_by(1, 'asc');

        $this->db->where('sent', NULL);

        $this->db->limit($limit);

        $data = $this->db->get('agents_sms_queue');

        if ($data->num_rows()) {
            foreach ($data->result() as $row) {
                $results[] = $row;
            }
        }

        return $results;
    }

    function updateSmsQueue($phonenumber, $update_param) {

        $this->db->where('phone', $phonenumber);

        return $this->db->update('agents_sms_queue', $update_param);
    }

   
    function createRequest($phonenumber, $message) {

        $request = (array());

        $AuthDetails = array(
            'UserID' => $this->user_id,
            'Token' => $this->token,
            'Timestamp' => "$this->timestamp"
        );

        $MessageType = array('3');

        $BatchType = array('1');

        $SourceAddr = array('BeautyClick');

        $MessagePayload = array(
            'Text' => "$message"
        );

        $DestinationAddr = array(
            'MSISDN' => "$phonenumber"
        );

        $DeliveryRequest = array(
            'EndPoint' => 'https://beauty.click/cportal/index.php/sms/processSmsDeliveryReport',
            'Correlator' => time()
        );

        $request = array(
            'AuthDetails' => array($AuthDetails),
            'MessageType' => $MessageType,
            'BatchType' => $BatchType,
            'SourceAddr' => $SourceAddr,
            'MessagePayload' => array($MessagePayload),
            'DestinationAddr' => array($DestinationAddr),
            'DeliveryRequest' => array($DeliveryRequest)
        );

        return $request;
    }

    function surftechsendSms($phonenumber, $message) {

        //API Url
        $url = 'http://197.248.4.47/smsapi/submit.php';

        //Initiate cURL.
        $ch = curl_init($url);

        //The JSON data.                

        $jsonData = $this->createRequest($phonenumber, $message);

        //Encode the array into JSON.
        $jsonDataEncoded = json_encode($jsonData);

        //Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POST, 1);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        //Execute the request
        $result = curl_exec($ch);

        return true;
    }

    
    function createRequestNew($phonenumber, $message) {

        $request = (array());

        $AuthDetails = array(
            'UserID' => $this->user_id,
            'Token' => $this->token,
            'Timestamp' => "$this->timestamp"
        );

        $MessageType = array('3');

        $BatchType = array('1');

        $SourceAddr = array('BeautyClick');

        $MessagePayload = array(
            'Text' => "$message"
        );

        $DestinationAddr = array(
            'MSISDN' => "$phonenumber"
        );

        $DeliveryRequest = array(
            'EndPoint' => 'https://beauty.click/cportal/index.php/sms/processSmsDeliveryReport',
            'Correlator' => time()
        );

        $request = array(
            'AuthDetails' => array($AuthDetails),
            'MessageType' => $MessageType,
            'BatchType' => $BatchType,
            'SourceAddr' => $SourceAddr,
            'MessagePayload' => array($MessagePayload),
            'DestinationAddr' => array($DestinationAddr),
            'DeliveryRequest' => array($DeliveryRequest)
        );

        return $request;
    }


    function surftechsendSmsNew($phonenumber, $message) {

        //API Url
        $url = 'http://197.248.4.47/smsapi/submit.php';

        //Initiate cURL.
        $ch = curl_init($url);

        //The JSON data.                

        $jsonData = $this->createRequestNew($phonenumber, $message);

        //Encode the array into JSON.
        $jsonDataEncoded = json_encode($jsonData);

        //Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POST, 1);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        //Execute the request
        $result = curl_exec($ch);

        return true;
    }
    
    
    public function sendNewSms($phonenumber, $message){

	$url = 'https://isms.infosky.co.ke/sms2/api/v1/send-sms';

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer ACCESS_TOKEN')); //setting custom header

	$curl_post_data = array(
	  //Fill in the request parameters with valid values
	  'acc_no' => "0145",
	  'api_key' => "g8s4J8J6HYT8r5q8p1G5N3V9G9dAB9bu",
	  'sender_id' => "Beautyclick",
	  'message' => "$message",
	  'msisdn' => [$phonenumber],
	  'dlr_url' => ""
	);

	$data_string = json_encode($curl_post_data);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

	$curl_response = curl_exec($curl);
	//print_r($curl_response);

	//echo $curl_response;

    return true;

	}
  
  
}
