<?php
/**
 * The User class represents a user and provides methods for registration, login, getting users, and logging out.
 * It extends the DbConfig class which provides a method to establish a connection to a MySQL database.
 */
require_once "DbConfig.php";

/**
 * The User class extends the DbConfig class and provides methods to manage user accounts in the database.
 */
class User extends DbConfig{

    /**
     * Registers a new user account in the database.
     *
     * @param array $data An array containing the user's registration data, including voornaam, tussenvoegsel, achternaam, gebruikersnaam, email, password, and rollenid.
     *
     * @throws Exception If the passwords do not match or the account cannot be created in the database.
     */
    public function register($data){
        try{
            if($data['password'] != $data['conf-password']){
                throw new Exception("Wachtwoorden komen niet overeen met elkaar.");
            }
            $sql = "INSERT INTO users (voornaam, tussenvoegsel, achternaam, gebruikersnaam, email, password, rollenid) VALUES (:voornaam, :tussenvoegsel, :achternaam, :gebruikersnaam, :email, :password, :rollenid)";
            $encryptedPassword = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":voornaam", $data['voornaam']);
            $stmt->bindParam(":tussenvoegsel", $data['tussenvoegsel']);
            $stmt->bindParam(":achternaam", $data['achternaam']);
            $stmt->bindParam(":gebruikersnaam", $data['voornaam']);
            $stmt->bindParam(":email", $data['email']);
            // $stmt->bindParam(":telnr", $data['telnr']);
            $stmt->bindParam(":rollenid", $data['option']);
            $stmt->bindParam(":password", $encryptedPassword);
            if(!$stmt->execute()){
                throw new Exception("Account kon niet aangemaakt worden");
            }
            header("Location: login.php");
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }



}


?>