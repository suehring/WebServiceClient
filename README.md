# WebServiceClient class
Web Service Client Class (using cURL)

<?php
require_once("WebServiceClient.php");
$url = "http://YOURURL";
$client = new WebServiceClient($url);

// Default is to POST. If you need to change to a GET, here's how:
//$client->setMethod("GET");

$apikey = "apiNN";
$apihash = "8675309";
$data = array("username" => $username, "password" => $password);
$action = "authenticate";
$fields = array("apikey" => $apikey,
             "apihash" => $apihash,
              "data" => $data,
             "action" => $action,
             );
$client->setPostFields($fields);

//For Debugging:
//var_dump($client);

print $client->send();
