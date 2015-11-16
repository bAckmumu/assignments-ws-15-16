<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class DBHandler
{
    const TABLE_USERS = 'users';
    const TABLE_NOTES = 'notes';
    var $connection;

    /**
     * @param $host String host to connect to.
     * @param $user String username to use with the connection. Make sure to grant all necessary privileges.
     * @param $password String password belonging to the username.
     * @param $db String name of the database.
     */
    function __construct($host,$user,$password,$db){
        $this->connection = new mysqli($host,$user,$password,$db);
        $this->connection->set_charset('utf8'); // prevent charset errors.
        $this->ensureUsersTable();
        $this->ensureNotesTable();
    }

    /**
     * creates a database record for the given user and password.
     * @param $artistName name of te album's artist
     * @param $albumTitle title of the album
     * @return bool true for success, false for error
     */
    function insertUser($userName,$passwordHash){
        $user = array();
        if($this->connection){
            // because the user name and password hash come from user input, we better user prepared statements.
            $queryString = "INSERT INTO users (name,password) VALUES (?,?)";

            $statement = $this->connection->prepare($queryString);
            $statement->bind_param("ss",$userName,$passwordHash);
            $statement->execute();
            if($statement->error){
                $user["error"] = "insertUser failed";
            }
            
            $user = $this->fetchUserByName($userName);
        }
        return $user;
    }

    /**
     * @return array of rows (id, artist, title)
     */
    function fetchUserByName($name){
        $user = array();
        if($this->connection){
            $queryString = "SELECT id,name,password FROM users WHERE name = ?";

            $statement = $this->connection->prepare($queryString);
            $statement->bind_param("s",$name);
            $statement->execute();
            //$statement->bind_result($id,$name,$wHash);

            if($statement->error){
                $user["error"] = "fetchUserByName failed";
            }
            else{
                $result = $statement->get_result();
                $user = $result->fetch_assoc();
            }
        }

        return $user;
    }

    /**
     * creates a database record for the given artist and title.
     * @param $artistName name of te album's artist
     * @param $albumTitle title of the album
     * @return bool true for success, false for error
     */
    function insertNote($userId,$title,$text){
        if($this->connection){
            // because the artist name and album title come from user input, we better user prepared statements.
            $queryString = "INSERT INTO notes (user_id,note_title,note_text) VALUES (?,?,?)";

            $statement = $this->connection->prepare($queryString);
            $statement->bind_param("iss",$userId,$title,$text);
            $statement->execute();
                        
            if($statement->error){
                echo $statement->error;
                return false;
            }
            else{
                return true;
            }
        }
        return false;
    }

    /**
     * @return array of rows (id, artist, title)
     */
    function fetchNotesByUser($userId){
        $notes = array();
        if($this->connection){
            $queryString = "SELECT id,note_title,note_text FROM notes WHERE user_id = ?";

            $statement = $this->connection->prepare($queryString);
            $statement->bind_param("i",$userId);
            $statement->execute();
            $statement->bind_result($id,$title,$text);

            while($statement->fetch()){
                $notes[] = array( "id"=>$id,"title"=>$title,"text"=>$text);
            }
        }
        return $notes;
    }

    /**
     * die id unter Mysql soll ein int sein kann das nicht sicherheitstechnis ein Problem sein?
     */
    function deletNotesByIds($ids){
        if($this->connection){
            $queryString = "DELETE FROM notes WHERE id=?";
            $statement = $this->connection->prepare($queryString);

            foreach ($ids as $id) {
                $statement->bind_param("i",$id);
                $statement->execute();
            }
        }
    }

    /**
     * makes sure that the albums table is present in the database
     * before any interaction occurs with it.
     */
    function ensureUsersTable(){
        if($this->connection){
            $queryString = "CREATE TABLE IF NOT EXISTS users 
            (
                id INT NOT NULL AUTO_INCREMENT, 
                name VARCHAR(100) NOT NULL UNIQUE, 
                password VARCHAR(255) NOT NULL,
                PRIMARY KEY (id)
            )";
            // it's okay not to use prepared statements here
            // because it is quite a static thing to do and does not take potentially harmful user input.
            $this->connection->query($queryString);
        }
    }

    /**
     * makes sure that the albums table is present in the database
     * before any interaction occurs with it.
     */
    function ensureNotesTable(){
        if($this->connection){
            $queryString = "CREATE TABLE IF NOT EXISTS notes 
            (
                id INT NOT NULL AUTO_INCREMENT, 
                user_id INT NOT NULL, 
                note_title VARCHAR(255), 
                note_text VARCHAR(1024) NOT NULL,
                PRIMARY KEY (id),
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )";
            // it's okay not to use prepared statements here
            // because it is quite a static thing to do and does not take potentially harmful user input.
            $this->connection->query($queryString);
        }
    }

    /**
     * useful to sanitize data before trying to insert it into the database.
     * @param $string String to be escaped from malicious SQL statements
     */
    function sanitizeInput(&$string){
        $string = $this->connection->real_escape_string($string);
    }
}