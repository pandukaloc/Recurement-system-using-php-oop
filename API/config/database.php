<?php




//class Database{
//
//    // specify your own database credentials
//    private $host ="127.0.0.1";
//    private $db_name="test";
//    private $username="root";
//    private $password="rootpasswordgiven";
//
//    // get the database connection
//    public function getDBConnection(){
//
//        $this->conn = null;
//
//        try{
//            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
//            $this->conn->exec("set names utf8");
//        }catch(PDOException $exception){
//            echo "Connection error: " . $exception->getMessage();
//        }
//
//        return $this->conn;
//    }
//}
class Database
{
    private $host ="127.0.0.1";
    private $db_name="radusdb";
    private $username="root";
    private $password="rootpasswordgiven";
    public  $conn;

    // get the database connection
    public function getDBConnection(){

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
