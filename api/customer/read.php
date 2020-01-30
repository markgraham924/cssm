<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/customer.php';
 
// instantiate database and customer object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$customer = new Customer($db);

// query customers
$stmt = $customer->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
 
    // customers array
    $customers_arr=array();
    $customers_arr["records"]=array();
 
    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $customer_item=array(
            "id" => $id,
            "cname" => $cname,
            "caddress" => $caddress
        );
 
        array_push($customers_arr["records"], $customer_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show customers data in json format
    echo json_encode($customers_arr);
} else {
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no customers found
    echo json_encode(
        array("message" => "No customers found.")
    );
}