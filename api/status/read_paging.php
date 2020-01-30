<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/status.php';
 
// utilities
$utilities = new Utilities();
 
// instantiate database and status object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$status = new Status($db);
 
// query status's
$stmt = $status->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // status array
    $status_arr=array();
    $status_arr["records"]=array();
    $status_arr["paging"]=array();
 
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
 
 
    // include paging
    $total_rows=$status->count();
    $page_url="{$home_url}status/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $status_arr["paging"]=$paging;
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($status_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user status does not exist
    echo json_encode(
        array("message" => "No status's found.")
    );
}
?>