<?php
class dbconnect{
  public $conn;
  public function __construct()
  {
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "ishow";
     
     $conn = new mysqli($servername, $username, $password, $dbname);
     $this->conn = $conn;
    }
  function connection(){
       return $this->conn;
  }     
  }

?>