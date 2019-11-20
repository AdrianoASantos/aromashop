<?php

namespace MF\DB;

use PDO;

class Sql extends PDO {

    const DBNAME = "db_aroma";
    const HOSTNAME = "127.0.0.1";
    const USER = "root";
    const PASSWORD = "";

    private $conn;

    public function __Construct(){
        $this->conn = new PDO(
            "mysql:dbname=".Sql::DBNAME.";host=".Sql::HOSTNAME,
            Sql::USER,
            Sql::PASSWORD
        );
    }

    private function setParam($statement, $key,$value){
        $statement->bindParam($key,$value);
    }

    private function setParams($statement, $params = array()){
        foreach($params as $key => $value){
            $this->setParam($statement,$key,$value);
        }
    }

    public  function query($rowQuery, $params = array()){
        $stmt = $this->conn->prepare($rowQuery);

        $this->setParams($stmt,$params);

        $stmt->execute();

        return $stmt;
    }

    public function select($rowQuery, $params = array()){
        $stmt = $this->query($rowQuery,$params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}











?>