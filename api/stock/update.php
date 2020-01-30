<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/stock.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare stock object
$stock = new Stock($db);

// set ID property of stock to be edited
$stock->productID = $_POST["productID"];
 
// set stock property values
$stock->stockPosition = $_POST["stockPosition"];
$stock->statusID = $_POST["statusID"];

// update the stock
if($stock->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Stockfile was updated."));
}
 
// if unable to update the stock, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to update stockfile."));
}
?>