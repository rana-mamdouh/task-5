<?php

class configuration {
    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "nti";
    private $connection;
    public function __construct() {
        $this->connection = new mysqli($this->hostname,$this->username,$this->password,$this->database);
    }
    
    public function runDML(string $query) : bool
    {
        $result = $this->connection->query($query);
        if($result){
            return true;
        }
        return false;
    }

    public function runDQL(string $query) 
    {
      
        $result = $this->connection->query($query);


        if($result->num_rows > 0){
            return $result;
        }
        return [];
    }
}
// $x = new config;