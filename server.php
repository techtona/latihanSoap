<?php

require_once("./lib/nusoap.php");
 
//Create a new soap server
$server = new soap_server();
$server->configureWSDL('server', 'urn:server');

$server->wsdl->schemaTargetNamespace = 'urn:server';

// SOAP complex type return type (an array/struct)
$server->wsdl->addComplexType(
   'Person',
   'complexType',
   'struct',
   'all',
   '',
   array('id_user' => array('name' => 'id_user',
         'type' => 'xsd:int'))
);

$server->register('getCustomer',
         array('customerNumber' => 'xsd:string'),   // parameter
         array('return' => 'xsd:string'),     // output
         'urn:server',                        // namespace
         'urn:server#helloServer',            // soapaction
         'rpc',                               // style
         'encoded',                           // use
         'mendapatkan 1 customer');                   // description



function getCustomer($customerNumber) {
    require_once "./connect.php";

    $query = "SELECT customerName FROM customers WHERE customerNumber = ".$customerNumber."";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            return $row["customerName"];
        }
    } else {
        return "0 results";
    }
}

$server->register('updateCustomer',
         array(
             'customerNumber' => 'xsd:string',
             'customerName' => 'xsd:string',
            ),   // parameter
         array('return' => 'xsd:string'),     // output
         'urn:server',                        // namespace
         'urn:server#helloServer',            // soapaction
         'rpc',                               // style
         'encoded',                           // use
         'update customer');                   // description

function updateCustomer($customerNumber, $customerName){
    require_once "./connect.php";

    $query = "UPDATE customers SET customerName='".$customerName."' WHERE customerNumber=".$customerNumber."";

    if (mysqli_query($conn, $query)) {
        return "berhasil";
    } else {
        return "Error updating record: " . mysqli_error($conn);
    }
}


$GLOBALS['HTTP_RAW_POST_DATA'] = file_get_contents ('php://input');
$HTTP_RAW_POST_DATA = $GLOBALS['HTTP_RAW_POST_DATA'];

// Use the request to invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);