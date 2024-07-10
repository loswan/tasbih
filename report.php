<?php

$conn = mysqli_connect("localhost","root","","db");
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
$message = "test ya";
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.fonnte.com/send',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('target' => '083162336745','message' => $message),
  CURLOPT_HTTPHEADER => array(
    'Authorization: __J#kheaYPV4yJf+eyRE'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$res = json_decode($response,true);
var_dump($res);
foreach($res["id"] as $k=>$v){
  $target = $res["target"][$k];
  $status = $res["process"];
  mysqli_query($conn,"INSERT INTO report (id,target,message,status) VALUES ('$v','$target','$message','$status')");
}
