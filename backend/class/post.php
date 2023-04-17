<?php

require_once "DbConfig.php";

class Post extends DbConfig{

    /**
     * Creates a new post in the database with the provided data
     *
     * @param array $data An associative array containing the post data (title, description, body)
     *
     * @return void
     */
    public function createPosts($data){
        $author = $_SESSION['id'];
        try{
            // Check if a post with the same title already exists
            $sql_check = "SELECT COUNT(*) FROM posts WHERE title = :title AND description = :description AND body = :body AND author = :auth AND kapster = :kapster";
            $stmt_check = $this->connect()->prepare($sql_check);
            $stmt_check->bindParam(":title", $data['title']);
            $stmt_check->bindParam(":description", $data['description']);
            $stmt_check->bindParam(":body", $data['body']);
            $stmt_check->bindParam(":auth", $author);
            $stmt_check->bindParam(":kapster", $data['option']);
            $stmt_check->execute();
            $count = $stmt_check->fetchColumn();

            if ($count > 0) {
                throw new Exception("This post already exists");
            }

            // Create a new post if no post with the same title exists
            $sql_insert = "INSERT INTO posts (title, description, body, author, kapster) VALUES (:title, :description, :body, :auth, :kapster)";
            $stmt_insert = $this->connect()->prepare($sql_insert);
            $stmt_insert->bindParam(":title", $data['title']);
            $stmt_insert->bindParam(":description", $data['description']);
            $stmt_insert->bindParam(":body", $data['body']);
            $stmt_insert->bindParam(":auth", $author);
            $stmt_insert->bindParam(":kapster", $data['option']);
            if(!$stmt_insert->execute()){
                throw new Exception("Post kon niet aangemaakt worden");
            }
            header("Location: myposts.php");
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Creates a new post in the database with the provided data
     *
     * @param array $data An associative array containing the post data (title, description, body)
     *
     * @return void
     */
    public function createPost($data){
        $author = $_SESSION['id'];
        try{
            $sql = "INSERT INTO posts (title, description, body, author, kapster) VALUES (:title, :description, :body, :auth, :kapster)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":title", $data['title']);
            $stmt->bindParam(":description", $data['description']);
            $stmt->bindParam(":body", $data['body']);
            $stmt->bindParam(":auth", $author);
            $stmt->bindParam(":kapster", $data['option']);
            if(!$stmt->execute()){
                throw new Exception("Post kon niet aangemaakt worden");
            }
            header("Location: myposts.php");
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    
    /**
     * Updates a post with given data and ID.
     *
     * @param array $data The data to update the post with.
     * @param int $id The ID of the post to update.
     * @throws Exception If the update query fails.
     */
    public function editpost($data, $id){
        try{
            $sql = "UPDATE posts SET  title=:title, description=:description, body=:body, kapster=:kapster WHERE id= :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":title", $data['title']);
            $stmt->bindParam(":description", $data['description']);
            $stmt->bindParam(":body", $data['body']);
            $stmt->bindParam(":kapster", $data['option']);
            $stmt->bindParam(":id", $id);
            if(!$stmt->execute()){
                throw new Exception("Gegevens niet veranderd");
            }
            session_start();
            $post = new Post();
            foreach ($post->getPostFromUser($_SESSION['id']) as $postData) {
                header("Location: postinfo.php?posts=$postData->id");
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Get all posts from a specific user.
     * 
     * @param int $id The ID of the user.
     * @return array An array of post objects.
     */
    public function getPostFromUser($id){
        $sql = "SELECT * FROM posts WHERE author = :author AND deleted = 0";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":author", $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    /**
     * Get a specific post with information about its author.
     * 
     * @param int $PostID The ID of the post.
     * @return array An array containing the post object and its author information.
     */
    public function getPostID($PostID){
        $sql = "SELECT * FROM posts
                JOIN users on users.id = posts.author
                WHERE posts.id = :postID";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':postID', $PostID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Retrieves all posts from the database.
     *
     * @return array An array of post objects
     */
    public function getPost(){
        $sql = "SELECT * FROM posts WHERE deleted = 0";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Deletes a post by setting its "deleted" field to 1 in the database.
     *
     * @param array $data The data associated with the post to be deleted
     * @param int $id The ID of the post to be deleted
     * @throws Exception if the post data cannot be updated in the database
     */
    public function deletePost($data, $id){
        try{
            $sql = "UPDATE posts SET  deleted = 1 WHERE id= :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":id", $id);
            if(!$stmt->execute()){
                throw new Exception("Post kon niet verwijderd worden");
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Adds a comment to a post in the database.
     *
     * @param array $data The data associated with the comment to be added
     * @throws Exception if the comment data cannot be inserted into the database
     */
    public function comment($data){
        try{
            $sql = "INSERT INTO comments (message, author, post_id) VALUES (:message, :author, :post_id)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":message", $data['message']);
            $stmt->bindParam(":author", $data['naam']);
            $stmt->bindParam(":post_id", $data['postId']);
            if(!$stmt->execute()){
                throw new Exception("Message kon niet worden geplaats");
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Creates a new user in the database with the given data
     *
     * @param array $data An associative array containing user data, including 'voornaam', 'tussenvoegsel', 'achternaam', 'gebruikersnaam', 'email', 'password', and optionally 'option'
     *
     * @return array An array of objects representing the newly created user, or an error message if the account could not be created
     *
     * @throws Exception if the password and confirmation password do not match or if the account could not be created for any other reason
     */
    public function getComments($id){
        $sql = "SELECT * FROM comments WHERE post_id = :postId AND deleted = 0";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":postId", $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Creates a new user in the database with the given data
     *
     * @param array $data An associative array containing user data, including 'voornaam', 'tussenvoegsel', 'achternaam', 'gebruikersnaam', 'email', 'password', and optionally 'option'
     *
     * @return array An array of objects representing the newly created user, or an error message if the account could not be created
     *
     * @throws Exception if the password and confirmation password do not match or if the account could not be created for any other reason
     */
    public function deleteComment($id){
        $sql = "UPDATE comments SET deleted = 1 WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

}

?>