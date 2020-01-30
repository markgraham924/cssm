<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate customer object
include_once '../objects/customer.php';
 
$database = new Database();
$db = $database->getConnection();
 
$customer = new Customer($db);
 
// get posted data
$cname = $_POST["cname"];
$caddress = $_POST["caddress"];

echo $data;
 
// make sure data is not empty
if(
    !empty($cname) &&
    !empty($caddress)
){
 
    // set customer property values
    $customer->cname = $cname;
    $customer->caddress = $caddress;

    // create the customer
    if($customer->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Customer was created."));
    }
 
    // if unable to create the customer, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create customer."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create customer. Data is incomplete."));
}
?>
