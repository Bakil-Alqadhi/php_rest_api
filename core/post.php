<?php 

class Post {
    private $conn;
    private $table = 'posts';

    // post properties 
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;
    
    //constructor for connection with db
    public function __construct($db){
        $this->conn= $db;
    } 
    // getting posts from out db
    public function read(){
        // create query
        $query = 'SELECT 
            c.name as category_name, 
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author, 
            p.created_at   
            FROM '.$this->table. ' p 
            LEFT JOIN 
                categories c ON p.category_id = c.id
                ORDER BY p.created_at DESC'
        ;

        //prepare the statement
        $stat = $this->conn->prepare($query);
        //execute the query
        $stat->execute();
        return $stat;
    }
    public function read_single($id){
        $query = 'SELECT 
                c.name as category_name,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
                FROM '.$this->table. ' p 
                LEFT JOIN 
                categories c ON p.category_id = c.id
                WHERE p.id= :id '
                ;
        $stat = $this->conn->prepare($query);
        $stat->bindParam(':id', $id);
        $stat->execute();

        return $stat;
    }

    public function create(){
        $query = 'INSERT INTO ' . $this->table . '(title, body, author, category_id) values(:title, :body, :author, :category_id) ';
        //prepare statement
        $stat = $this->conn->prepare($query);

        //clear data
        /**
         * htmlspecialchars() is a built-in PHP function that is used to convert special characters to their HTML entities. 
         * This is useful when displaying user-generated content on a web page to prevent cross-site scripting (XSS) attacks.
         */
        $this->title = htmlspecialchars($this->title);
        $this->body = htmlspecialchars($this->body);
        $this->author = htmlspecialchars($this->author);
        $this->category_id = htmlspecialchars($this->category_id);

        //binding of parameters
        $stat->bindParam(':title', $this->title);
        $stat->bindParam(':body', $this->body);
        $stat->bindParam(':author', $this->author);
        $stat->bindParam(':category_id', $this->category_id);

        if($stat->execute()){
            return true;
        }


        printf('Error %s. \n', $stat->error);
        return false;
    }
     public function update(){
        $query = 'UPDATE ' . $this->table . ' SET title = :title, body = :body, author = :author, category_id = :category_id
                    WHERE id = :id';
        //prepare statement
        $stat = $this->conn->prepare($query);

        //clear data
        $this->title = htmlspecialchars($this->title);
        $this->body = htmlspecialchars($this->body);
        $this->author = htmlspecialchars($this->author);
        $this->category_id = htmlspecialchars($this->category_id);
        $this->id = htmlspecialchars($this->id);

        //binding of parameters
        $stat->bindParam(':title', $this->title);
        $stat->bindParam(':body', $this->body);
        $stat->bindParam(':author', $this->author);
        $stat->bindParam(':category_id', $this->category_id);
        $stat->bindParam(':id', $this->id);

        if($stat->execute()){
            return true;
        }


        printf('Error %s. \n', $stat->error);
        return false;
    }

    public function delete(){
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        $stat = $this->conn->prepare($query);
        //clear data 
        $this->id = htmlspecialchars($this->id);
        $stat->bindParam(':id', $this->id);
        if($stat->execute()){
            return true;
        }

        printf('Error %s. \n', $stat->error);
        return false;
    }
    
}


?>