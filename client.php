<?php
require_once('./lib/nusoap.php');
// This is your Web service server WSDL URL address
$wsdl = "http://localhost/server.php?wsdl";

// Create client object
$client = new nusoap_client($wsdl, 'wsdl');
$err = $client->getError();
if ($err) {
   // Display the error
   echo '<h2>Constructor error</h2>' . $err;
   // At this point, you know the call that follows will fail
   exit();
}

// Call the hello method
// $result1=$client->call('getCustomer', array('customerNumber'=>'103'));
//  $result1=$client->call('updateCustomer', array('customerNumber'=>'103','customerName' => 'Jati Pikukuh'));
 $result1=$client->call('deletCustomer', array('customerNumber'=>'103'));

print_r($result1).'\n';
?>