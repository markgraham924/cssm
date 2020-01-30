<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/status.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare status object
$status = new Status($db);
 
// set ID property of record to read
$status->statusID = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of status to be edited
$status->readOne();
 
if($status->statusID!=null){
    // create array
    $status_arr = array(
        "ID" =>  $status->statusID,
        "Name" => $status->statusName,
        "Colour" => $status->statusColour,
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($status_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user status does not exist
    echo json_encode(array("message" => "Status does not exist."));
}
?>