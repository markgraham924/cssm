<?php

    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Max-Age: 3600");

    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/product.php';
 
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // initialize object
    $product = new Product($db);

    // get keywords
    $upc=isset($_GET["upc"]) ? $_GET["upc"] : "";

    // query products
    $stmt = $product->stockEnquiry($upc);
    $num = $stmt->rowCount();

    // check if more than 0 record found
    if($num>0){
    
        // products array
        $products_arr=array();
        $products_arr["records"]=array();

        // retrieve our table contents
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
    
            $product_item=array(
                "UPC" => $upc,
                "Product-Name" => $pname,
                "Stock-Position" => $stockPosition,
                "Status-Name" => $statusName,
                "Status-Colour" => $statusColour
            );
    
            array_push($products_arr["records"], $product_item);
        }
    
        // set response code - 200 OK
        http_response_code(200);
    
        // show products data
        echo json_encode($products_arr);
    }
    
    else{
        // set response code - 404 Not found
        http_response_code(404);
    
        // tell the user no products found
        echo json_encode(
            array("message" => "No products found.")
        );
    }
?>