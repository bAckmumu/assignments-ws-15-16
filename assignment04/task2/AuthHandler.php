<?php

class AuthHandler
{
    var $dbHandler;

    /**
     * @param $host String host to connect to.
     * @param $user String username to use with the connection. Make sure to grant all necessary privileges.
     * @param $password String password belonging to the username.
     * @param $db String name of the database.
     */
    function __construct($handler){
        $this->dbHandler = $handler;
    }
    
    /**
     * creates a database record for the given user and password.
     * @param $artistName name of te album's artist
     * @param $albumTitle title of the album
     * @return bool true for success, false for error
     */
    function registerUser($userName,$password){
        
        $this->dbHandler->sanitizeInput($userName);
        $this->dbHandler->sanitizeInput($password);
        
        $pwHash = password_hash($password,PASSWORD_DEFAULT);

        if($this->dbHandler->insertUser($userName,$pwHash)){
                return true;
        }
        return false;
    }
    
    /**
     * creates a database record for the given user and password.
     * @param $artistName name of te album's artist
     * @param $albumTitle title of the album
     * @return bool true for success, false for error
     */
    function loginUser($userName,$password){
        $this->dbHandler->sanitizeInput($userName);
        $this->dbHandler->sanitizeInput($password);

        $user = $this->dbHandler->fetchUserByName($userName);
        if (isset($user["error"])){
            return $user;
        }

        if ( count($user) != 3 ){
            return $this->registerUser($userName,$password);
        }

        if ( $userName === $user["name"] && password_verify($password, $user["password"])) {
            unset($user["password"]);//array_pop($user);
            return $user;
        }
        return array( "error" => "Wrong user name or password." );
    }

}