<?php
class dbconnect{
    public $conn;
 public function __construct()
 {
     session_start();
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "test";
     
     $conn = new mysqli($servername, $username, $password, $dbname);
     $this->conn = $conn;
    }
  function connection(){
      return $this->conn;
  }  
}
?>