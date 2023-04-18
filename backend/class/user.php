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
            $user = $this->getUserData($data['email']);
            if (!$user) {
                throw new Exception('Gebruiker bestaat niet.');
            }
            if(!password_verify($data['password'], $user[0]->password)){
                throw new Exception("wachtwoord is incorrect.");
            }
            session_start();
            $_SESSION['ingelogd'] = true;
            $_SESSION['id'] = $user[0]->id;
            $_SESSION['email'] = $user[0]->email;
            if($user[0]->rollenid == 1) {
                $_SESSION['admin'] = true;
            } elseif($user[0]->rollenid == 3) {
                $_SESSION['eigenaar'] = true;
            } 
            // header("Location: backend/index.php");
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }
    

    /**
     * Retrieves user data by id or email.
     * 
     * @param $identifier int|string - User id or email.
     * 
     * @return array - Array of user data.
     */
    public function getUserData($identifier){
        try{
            $sql = "SELECT * FROM users WHERE id = :id OR email = :email AND deleted = 0";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":id", $identifier);
            $stmt->bindParam(":email", $identifier);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }catch(Exception $e){
            echo $e->getMessage();
        }
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
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Logs out the user by destroying the current session and redirecting to the login page.
     */
    public function logout(){
        session_start(); // start the session
        session_destroy(); // destroy the session and delete all session data
        header("Location:../login.php"); // redirect to the login page
    }


    /**
     * Updates the user's information in the database based on the given data.
     *
     * @param array $data An array containing the updated user information (voornaam, tussenvoegsel, achternaam, email, password).
     *
     * @throws Exception If the data could not be updated in the database.
     */
    public function userUpdate($data){
        try{
            $sql = "UPDATE users SET voornaam=:voornaam, tussenvoegsel=:tussenvoegsel, achternaam=:achternaam, email=:email";
            if (!empty($data['password'])) {
                $sql .= ", password=:password";
                $encryptedPassword = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);
            }
            $sql .= " WHERE id=:id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":voornaam", $data['voornaam']);
            $stmt->bindParam(":tussenvoegsel", $data['tussenvoegsel']);
            $stmt->bindParam(":achternaam", $data['achternaam']);
            $stmt->bindParam(":email", $data['email']);
            $stmt->bindParam(":id", $data['id']);
            if (!empty($data['password'])) {
                $stmt->bindParam(":password", $encryptedPassword);
            }
            if(!$stmt->execute()){
                throw new Exception("Gegevens niet veranderd");
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    /**
    * Soft deletes a user from the database by setting the 'deleted' flag to 1
    *
    *@param int $id The id of the user to delete
    *
    *@return array An array of objects representing the deleted user, or an empty array if the user was not found
    */
    public function deleteUser($id){
        try{
            $sql = "UPDATE users SET deleted = 1 WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    
    //---------------------------------------------------------------------------------------//
    /**
     * Down here is the code for the admin users who can create, read, update and delete users.
     */
    //---------------------------------------------------------------------------------------//

    /**
    * Creates a new user in the database with the given data
    * @param array $data An associative array containing user data, including 'voornaam', 'tussenvoegsel', 'achternaam', 'gebruikersnaam', 'email', 'password', and optionally 'option'
    *
    * @return array An array of objects representing the newly created user, or an error message if the account could not be created
    *
    * @throws Exception if the password and confirmation password do not match or if the account could not be created for any other reason
    */
    public function createUser($data){
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
            if(isset($data['option'])) {
                $stmt->bindParam(":rollenid", $data['option']);
            } else {
                $stmt->bindValue(":rollenid", 2);
            }
            $stmt->bindParam(":password", $encryptedPassword);
            if(!$stmt->execute()){
                throw new Exception("Account kon niet aangemaakt worden");
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * getUsers retrieves all active users from the database
     * 
     * @return array An array of objects representing the active users in the database, or an error message if the retrieval failed
     * 
     * @throws Exception if the retrieval of the users fails for any reason
     */
    public function getUsers(){
        try{
            $sql = "SELECT * FROM users WHERE deleted = 0";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }


    /**
     * getUserById retrieves a user with the specified ID from the database
     * 
     * @param int $userId The ID of the user to retrieve
     * 
     * @return object An object representing the user with the specified ID, or an error message if the retrieval failed
     * 
     * @throws Exception if the retrieval of the user fails for any reason
     */
    public function getUserById($userId) {
        try {
            $sql = "SELECT * FROM users WHERE id = :userId";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":userId", $userId);
            $stmt->execute();
            $userData = $stmt->fetch(PDO::FETCH_OBJ);
            return $userData;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    

    /**
     * userUpdateEigenaar updates a user with the specified data in the database
     * 
     * @param array $data An associative array containing user data to update, including 'voornaam', 'tussenvoegsel', 'achternaam', 'gebruikersnaam', 'email', 'password', and optionally 'option'
     * 
     * @return bool true if the update was successful, or false if it failed
     * 
     * @throws Exception if the update of the user fails for any reason
     */
    public function userUpdateEigenaar($data){
        try{
            $sql = "UPDATE users SET voornaam = :voornaam, tussenvoegsel = :tussenvoegsel, achternaam = :achternaam, gebruikersnaam = :gebruikersnaam, email = :email, rollenid = :rollenid WHERE id = :userId";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindValue(":voornaam", $data['voornaam']);
            $stmt->bindValue(":tussenvoegsel", $data['tussenvoegsel']);
            $stmt->bindValue(":achternaam", $data['achternaam']);
            $stmt->bindValue(":gebruikersnaam", $data['gebruikersnaam']);
            $stmt->bindValue(":email", $data['email']);
            $stmt->bindValue(":rollenid", $data['option']);
            $stmt->bindValue(":userId", $data['userId']);
            return $stmt->execute();
        } catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

}


?>