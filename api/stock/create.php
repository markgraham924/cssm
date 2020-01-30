<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate stockFile object
include_once '../objects/stock.php';
 
$database = new Database();
$db = $database->getConnection();
 
$stock = new Stock($db);
 
// get posted data
$productID = $_POST["productID"];
$stockPosition = $_POST["stockPosition"];
$statusID = $_POST["statusID"];
 
// make sure data is not empty
if(
    !empty($productID) &&
    !empty($stockPosition) &&
    !empty($statusID)
){
 
    // set stock property values
    $stock->productID = $productID;
    $stock->stockPosition = $stockPosition;
    $stock->statusID = $statusID;
 
    // create the stock
    if($stock->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Product was created in stockFile."));
    }
 
    // if unable to create the stock, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create product in stockFile."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create product in stockFile. Data is incomplete."));
}
?>
