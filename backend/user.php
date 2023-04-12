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

    /**
     * Logs a user in by checking their email and password against the database.
     *
     * @param array $data An associative array containing the user's email and password.
     *
     * @return void
     *
     * @throws Exception If the user does not exist or if the password is incorrect.
     */
    public function login($data){
        try {
            $user = $this->getUser($data['email']);
            if (!$user) {
                throw new Exception('Gebruiker bestaat niet.');
            }
            if(!password_verify($data['password'], $user->password)){
                throw new Exception("wachtwoord is incorrect.");
            }
            session_start();
            $_SESSION['ingelogd'] = true;
            $_SESSION['email'] = $user->Email;
            header("Location: index.php");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Gets all users from the database.
     *
     * @return array An array containing all users.
     */
    public function getUsers(){
        $sql = "SELECT * FROM users";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Gets a user with the given email from the database.
     *
     * @param string $email The email of the user to retrieve.
     *
     * @return object|false An object representing the user if found, false otherwise.
     */
    public function getUser($email){
        $sql = "SELECT * FROM users WHERE Email = :email";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Checks if a user exists in the 'users' table of the database with the given email address.
     *
     * @param string $Email The email address of the user to check.
     *
     * @return object|false Returns an object representing the email address of the user if found, or false otherwise.
     *
     * @throws Exception If an error occurs while executing the SQL query.
     */
    public function check_user_exists($Email){
        try{
            $sql = "SELECT Email FROM users WHERE Email=:Email";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":Email", $Email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * Logs out the user by destroying the current session and redirecting to the login page.
     */
    public function uitloggen(){
        session_start(); // start the session
        session_destroy(); // destroy the session and delete all session data
        header("Location:../login.php"); // redirect to the login page
    }

}


?>