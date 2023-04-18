<?php
/**
 * The DbConfig class represents a database configuration and provides a method to establish a connection to a MySQL database.
 */
class DbConfig{

    /**
     * Establishes a connection to a MySQL database.
     *
     * @return PDO Returns a PDO object representing the database connection.
     *
     * @throws PDOException If an error occurs while connecting to the database.
     */
    public function connect(){
        try{
            $conn = new PDO("mysql:host=localhost;dbname=examen-training", 'root', '');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}
?>
