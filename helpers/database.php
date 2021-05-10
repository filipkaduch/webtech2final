<?php


class Database {


    public $conn;

    public function getConnection(){
        $this->conn = null;
        $username = "xkaduch";
        $password = "madrid";
        try{
            $this->conn = new PDO("mysql:host=localhost;dbname=final", $username, $password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $exception){
            echo "Database could not be connected: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
