<?php

class DbConfig{

    public function connect(){
        try{
            $conn = new PDO("mysql:host=localhost;dbname=kapsalontest", 'root', '');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

}

?>