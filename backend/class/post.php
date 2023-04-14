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
            $sql = "INSERT INTO posts (title, description, body, author) VALUES (:title, :description, :body, :auth)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":title", $data['title']);
            $stmt->bindParam(":description", $data['description']);
            $stmt->bindParam(":body", $data['body']);
            $stmt->bindParam(":auth", $author);
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
            $sql = "UPDATE posts SET  title=:title, description=:description, body=:body WHERE id= :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":title", $data['title']);
            $stmt->bindParam(":description", $data['description']);
            $stmt->bindParam(":body", $data['body']);
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
     * Retrieves all comments for a specific post
     * @param int $id The id of the post
     * @return array An array of comment objects
     */
    public function getComments($id){
        $sql = "SELECT * FROM comments WHERE post_id = :postId AND deleted = 0";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":postId", $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function deleteComment($id){
        $sql = "UPDATE comments SET deleted = 1 WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

}

?>