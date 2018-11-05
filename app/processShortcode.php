<?php

 $from = $_POST['from'];
 $to = $_POST['to'];
 $text = $_POST['text'];
 $date = $_POST['date'];
 $id = $_POST['id'];
 $linkId = $_POST['linkId'];

 $json_string = json_encode($_POST);

// file_get_contents("https://beauty.click/manage/api/short-code-callback/$json_string");

// set post fields
 $post = $_POST;

 $ch = curl_init("https://beauty.click/manage/api/short-code-callback");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

// execute!
 $response = curl_exec($ch);

// close the connection, release resources used
 curl_close($ch);

// do anything you want with your response
// var_dump($response);


?>