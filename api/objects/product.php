<?php
class Product{
    private $conn;
    private $table_name = "products";
 
    public $id;
    public $upc;
    public $pname;
    public $price;

    public function __construct($db){
        $this->conn = $db;
    }

    // read products with pagination
    public function readPaging($from_record_num, $records_per_page){
    
        // select query
        $query = "SELECT id, pname, price, upc FROM products LIMIT ?, ?";
    
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
        $query = "SELECT COUNT(*) as total_rows FROM products";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $row['total_rows'];
    }

    // read products
    function read(){
    
        // select all query
        $query = "SELECT id, upc, pname, price FROM " . $this->table_name;
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // create product
    function create(){

        // sanitize
        $this->pname=htmlspecialchars(strip_tags($this->pname));
        $this->upc=htmlspecialchars(strip_tags($this->upc));
        $this->price=htmlspecialchars(strip_tags($this->price));
    
        // query to insert record
        $query = "INSERT INTO products (pname, upc, price) VALUES ('$this->pname', '$this->upc', '$this->price') ";
            
        // prepare query
        $stmt = $this->conn->prepare($query);        
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
    // used when filling up the update product form
    function readOne(){
    
        // query to read single record
        $query = "SELECT id, upc, pname, price FROM products WHERE id = '$this->id' LIMIT 0,1";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->name = $row['pname'];
        $this->price = $row['price'];
        $this->description = $row['upc'];
    }
    // update the product
    function update(){

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->pname=htmlspecialchars(strip_tags($this->pname));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->upc=htmlspecialchars(strip_tags($this->upc));
    
        // update query
        $query = "UPDATE products SET pname = '$this->pname', price = $this->price, upc = $this->upc WHERE id = '$this->id'";
    
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
        $this->id=htmlspecialchars(strip_tags($this->id));

        // delete query
        $query = "DELETE FROM products WHERE id = '$this->id'";

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
        $query = "SELECT id, pname, upc, price FROM products WHERE pname LIKE '$keywords' OR upc LIKE '$keywords' OR price LIKE '$keywords'";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

}
?>