<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/stock.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare stock object
$stock = new Stock($db);
 
// set product id to be deleted
$stock->productID = $_POST["productID"];
 
// delete the product stock file
if($stock->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Product stock file was deleted."));
}
 
// if unable to delete the product stock file
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to delete product stock file."));
}
?>