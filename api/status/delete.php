<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/status.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare status object
$status = new Status($db);
 
// set status id to be deleted
$status->statusID = $_POST["statusID"];
 
// delete the status
if($status->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Status was deleted."));
}
 
// if unable to delete the status
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to delete the status."));
}
?>