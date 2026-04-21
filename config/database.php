<?php
class Database {
    private $host = "sql300.infinityfree.com";
    private $db_name = "if0_41712826_quanlydulich";
    private $username = "if0_41712826";
    private $password = "Doantram123";

    public function connect(){
        $conn = null;

        try{
            $conn = new PDO(
                "mysql:host=".$this->host.";dbname=".$this->db_name,
                $this->username,
                $this->password
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo "Connection error: ".$e->getMessage();
        }

        return $conn;
    }
}
?>