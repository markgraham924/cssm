<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/stock.php';
 
// instantiate database and stock object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$stock = new Stock($db);

// query stocks
$stmt = $stock->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
 
    // stocks array
    $stocks_arr=array();
    $stocks_arr["records"]=array();
 
    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $stock_item=array(
            "productUPC" => $upc,
            "stockPosition" => $stockPosition,
            "statusID" => $statusID
        );
 
        array_push($stocks_arr["records"], $stock_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show stocks data in json format
    echo json_encode($stocks_arr);
} else {
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no stocks found
    echo json_encode(
        array("message" => "No stock file found.")
    );
}