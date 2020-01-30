<?php
// 'stock' object
class Status{
 
    // database connection and table name
    private $conn;
    private $table_name = "stausTypes";
 
    // object properties
    public $statusID;
    public $statusName;
    public $statusColour;
 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // create new stock record
    function create(){

        // sanitize
        $this->statusName=htmlspecialchars(strip_tags($this->statusName));
        $this->statusColour=htmlspecialchars(strip_tags($this->statusColour));
        
        // insert query
        $query = "INSERT INTO statusTypes (statusName, statusColour) VALUES ('$this->statusName', '$this->statusColour') ";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }

        return false;
    }
    // read statuss with pagination
    public function readPaging($from_record_num, $records_per_page){
    
        // select query
        $query = "SELECT statusID, statusName, statusColour FROM statusTypes LIMIT ?, ?";
    
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
    // used for paging statuss
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM statusTypes";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $row['total_rows'];
    }

    // read statuss
    function read(){
    
        // select `all query
        $query = "SELECT statusID, statusName, statusColour FROM statusTypes";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // used when filling up the update status form
    function readOne(){
    
        // query to read single record
        $query = "SELECT statusID, statusName, statusColour FROM statusTypes WHERE statusID='$this->statusID'";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->statusID = $row['statusID'];
        $this->statusName = $row['statusName'];
        $this->statusColour = $row['statusColour'];
    }
    // update the status
    function update(){

        // sanitize
        $this->statusID=htmlspecialchars(strip_tags($this->statusID));
        $this->statusName=htmlspecialchars(strip_tags($this->statusName));
        $this->statusColour=htmlspecialchars(strip_tags($this->statusColour));
    
        // update query
        $query = "UPDATE statusTypes SET statusName = '$this->statusName', statusColour = '$this->statusColour' WHERE statusID = '$this->statusID' ";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }
    // delete the status
    function delete(){
    
        // sanitize
        $this->statusID=htmlspecialchars(strip_tags($this->statusID));

        // delete query
        $query = "DELETE FROM statusTypes WHERE statusID = '$this->statusID'";

        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
    // search status
    function search($keywords){

        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%$keywords%";
            
        // select all query
        $query = "SELECT statusID, statusName, statusColour FROM statusTypes WHERE statusID LIKE '$keywords' OR statusName LIKE '$keywords' OR statusColour LIKE '$keywords'";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

}

?>