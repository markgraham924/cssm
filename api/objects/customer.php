<?php
class Customer{
    private $conn;
    private $table_name = "customers";
 
    public $id;
    public $name;
    public $caddress;

    public function __construct($db){
        $this->conn = $db;
    }

    // read customers with pagination
    public function readPaging($from_record_num, $records_per_page){
    
        // select query
        $query = "SELECT id, cname, caddress FROM customers LIMIT ?, ?";
    
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
    // used for paging customers
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM customers";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $row['total_rows'];
    }

    // read customers
    function read(){
    
        // select all query
        $query = "SELECT id, cname, caddress FROM " . $this->table_name;
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // create customers
    function create(){

        // sanitize
        $this->cname=htmlspecialchars(strip_tags($this->cname));
        $this->caddress=htmlspecialchars(strip_tags($this->caddress));
    
        // query to insert record
        $query = "INSERT INTO customers (cname, caddress) VALUES ('$this->cname', '$this->caddress') ";
            
        // prepare query
        $stmt = $this->conn->prepare($query);        
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
    // used when filling up the update customers form
    function readOne(){
    
        // query to read single record
        $query = "SELECT id, cname, caddress FROM customers WHERE id = '$this->id' LIMIT 0,1";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->name = $row['cname'];
        $this->caddress = $row['caddress'];
    }
    // update the customers
    function update(){

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->cname=htmlspecialchars(strip_tags($this->cname));
        $this->caddress=htmlspecialchars(strip_tags($this->caddress));

        // update query
        $query = "UPDATE customers SET cname = '$this->cname', caddress = '$this->caddress' WHERE id = '$this->id'";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }
    // delete the customers
    function delete(){
    
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));

        // delete query
        $query = "DELETE FROM customers WHERE id = '$this->id'";

        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
    // search customers
    function search($keywords){

        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%$keywords%";
            
        // select all query
        $query = "SELECT id, cname, caddress FROM customers WHERE cname LIKE '$keywords' OR caddress LIKE '$keywords'";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

}
?>