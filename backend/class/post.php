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



}

?>