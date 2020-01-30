<?php
// 'stock' object
class Stock{
 
    // database connection and table name
    private $conn;
    private $table_name = "stockFile";
 
    // object properties
    public $productID;
    public $stockPosition;
    public $statusID;
 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // create new stock record
    function create(){
        // sanitize
        $this->productID=htmlspecialchars(strip_tags($this->productID));
        $this->stockPosition=htmlspecialchars(strip_tags($this->stockPosition));
        $this->statusID=htmlspecialchars(strip_tags($this->statusID));
        
        // insert query
        $query = "INSERT INTO stockFile SET productID = $this->productID, stockPosition = $this->stockPosition, statusID = $this->statusID";
        // prepare the query
        $stmt = $this->conn->prepare($query);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }

        return false;
    }
    // read products with pagination
    public function readPaging($from_record_num, $records_per_page){
    
        // select query
        $query = "SELECT products.upc, stockFile.stockPosition, statusTypes.statusName, statusTypes.statusID FROM ((stockFile INNER JOIN products ON products.ID = stockFile.productID)INNER JOIN statusTypes ON stockFile.statusID = statusTypes.statusID)LIMIT ?, ?";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind variable values
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
    
        // execute query
        $stmt->execute();
    
        // return values from database
        return $stmt;
    }
    // used for paging products
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM stockFile";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $row['total_rows'];
    }

    // read products
    function read(){
    
        // select `all query
        $query = "SELECT products.upc, stockFile.stockPosition, statusTypes.statusID, statusTypes.statusColour FROM ((stockFile INNER JOIN products ON products.ID = stockFile.productID)INNER JOIN statusTypes ON stockFile.statusID = statusTypes.statusID)";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // used when filling up the update product form
    function readOne(){
    
        // query to read single record
        $query = "SELECT products.upc, stockFile.stockPosition, statusTypes.statusID, statusTypes.statusColour FROM ((stockFile INNER JOIN products ON products.ID = stockFile.productID)INNER JOIN statusTypes ON stockFile.statusID = statusTypes.statusID) WHERE products.upc='$this->productID'";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->productID = $row['upc'];
        $this->stockPosition = $row['stockPosition'];
        $this->statusID = $row['statusID'];
    }
    // update the product
    function update(){

        // sanitize
        $this->productID=htmlspecialchars(strip_tags($this->productID));
        $this->stockPosition=htmlspecialchars(strip_tags($this->stockPosition));
        $this->statusID=htmlspecialchars(strip_tags($this->statusID));
    
        // update query
        $query = "UPDATE stockFile SET stockPosition = '$this->stockPosition', statusID = $this->statusID WHERE productID = '$this->productID'";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }
    // delete the product
    function delete(){
    
        // sanitize
        $this->productID=htmlspecialchars(strip_tags($this->productID));

        // delete query
        $query = "DELETE FROM stockFile WHERE productID = '$this->productID'";

        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
    // search products
    function search($keywords){

        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%$keywords%";
            
        // select all query
        $query = "SELECT products.upc, stockFile.stockPosition, statusTypes.statusName, statusTypes.statusID FROM ((stockFile INNER JOIN products ON products.ID = stockFile.productID)INNER JOIN statusTypes ON stockFile.statusID = statusTypes.statusID) WHERE stockFile.stockPosition LIKE '$keywords' OR stockFile.statusID LIKE '$keywords' OR products.upc LIKE '$keywords'";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

}

?>