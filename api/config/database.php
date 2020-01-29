<?php
    Class Database {
        private $host = "160.153.131.192";
        private $db_name = "cssm";
        private $username = "cssmAdmin";
        private $password = "%2u}MmUC;0IY";
        public $conn;

        public function getConnection(){
            $this->conn = null;
            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                $this->conn->exec("set names utf8");
            }catch(PDOException $exception){
                echo "Connection error: " . $exception->getMessage();
            }
            return $this->conn;
        }
    }
?>