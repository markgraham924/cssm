<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/stock.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare stock object
$stock = new Stock($db);
 
// set ID property of record to read
$stock->productID = isset($_GET['upc']) ? $_GET['upc'] : die();
 
// read the details of stock to be edited
$stock->readOne();
 
if($stock->productID!=null){
    // create array
    $stock_arr = array(
        "productUPC" =>  $stock->productID,
        "stockPosition" => $stock->stockPosition,
        "statusID" => $stock->statusID,
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($stock_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user stock does not exist
    echo json_encode(array("message" => "Stock does not exist."));
}
?>