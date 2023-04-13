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
            header("Location: allposts.php");
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    
}

?>