<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/status.php';
 
// instantiate database and status object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$status = new Status($db);

// query status
$stmt = $status->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
 
    // status array
    $status_arr=array();
    $status_arr["records"]=array();
 
    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $status_item=array(
            "ID" => $statusID,
            "Name" => $statusName,
            "Colour" => $statusColour
        );
 
        array_push($status_arr["records"], $status_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show status data in json format
    echo json_encode($status_arr);
} else {
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no status found
    echo json_encode(
        array("message" => "No status's found.")
    );
}