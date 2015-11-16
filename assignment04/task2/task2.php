<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task 2: Note-Taking Web-app</title>
    <style>
        body,html{
            font-family: 'Helvetica Neue','Helvetica', 'Arial', sans-serif;
            font-size: 20px;
            margin:0;
            padding:0;
            background-color: #AAA;
            color: black;
        }
        .error{
            color: red;
        }
        .success{
            color: greenyellow;
        }
        .notification{
            color: coral;
        }
        .error,.success, .notification{
            margin: 2em 0;
            border: 2px dotted white;
            padding: 2em;
        }

        #container{
            width: 90%;
            min-width: 700px;
            margin:auto;
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
        }

        table.albums{
            margin: 2em 0;
            width: 100%;
        }
        label{
            margin-right: 2em;
        }
        #loginContainer{
            margin: 2em 0;
            border: 2px solid white;
            padding: 0 1em 1em 1em;
        }
        #formContainer{
            margin: 2em 0;
            border: 2px solid white;
            padding: 0 1em 1em 1em;
        }
        #note{
            margin: 2em 0;
            border: 2px solid white;
            padding: 0 1em 1em 1em;
        }
    </style>
</head>

<?php

// this file holds the connection info in $host, $user, $password, $db;
include_once('connectionInfo.private.php');

// the DBHandler takes care of all the direct database interaction.
require_once('DBHandler.php');
require_once('AuthHandler.php');

$dbHandler = new DBHandler($host,$user,$password,$db);
$authHandler = new AuthHandler($dbHandler);
$errorMessage = "";

// now, let's see whether the user has submitted the form
if(isset($_POST['login'])){
    $user = $authHandler->loginUser($_POST['user'],$_POST['password']);

    if (isset($user["error"])){
        $errorMessage = $user["error"];
    }
    else {
        $_SESSION['loggedIn'] = $user; //array( "id" => 0, "user" => "manu", );
    }
}
elseif (isset($_POST['logout'])) {
    session_destroy();
    $_SESSION = array();  
}
elseif(isset($_POST['submit'])){
    $id = $_SESSION['loggedIn']['id'];
    $title = $_POST['title'];
    $text = $_POST['text'];

    $dbHandler->sanitizeInput($title);
    $dbHandler->sanitizeInput($text);

    if(!$dbHandler->insertNote($id,$title,$text)){
        $errorMessage = 'Faild saving note';
    }
    
}
elseif (isset($_POST['delte'])) {
    $notesToDelete = array();
    foreach ($_POST as $key => $value) {
        if ( strpos($key, "note") !== false ){
            $notesToDelete[] = $value;
        }   
    }

    $dbHandler->deletNotesByIds($notesToDelete);
}

?>

<body>
<div id="container">

<?php 
if(!empty($errorMessage)) {
    echo '<div class="notification" >'. $errorMessage .'</div>';
}
?>


<div id="loginContainer" >
    <?php 
    if(!isset($_SESSION['loggedIn'])){ 
    ?>
    <form method="post">
        <label>
            User:
            <input type="text" required name="user"/>
        </label>

        <label>
            Password:
            <input type="password" required name="password"/>
        </label>
        <input type="submit" name="login" value="Login" />
    </form>
    <?php 
    }
    else { 
    ?>
    <form method="post">
        <label>
            User: 
            <?php echo $_SESSION['loggedIn']['name']; ?>
        </label>
        <input type="submit" name="logout" value="Logout" />
    </form>
    <?php 
    } 
    ?>
</div>
<?php 
if (isset($_SESSION['loggedIn'])){
    echo '<div id="formContainer">
    <form method="post">
        <label>
            Title:
            <input type="text" required name="title"/>
        </label>
        <br>
        <label>
            Text:
            <textarea required name="text" rows="5" cols="40"></textarea>
        </label>
        <br>
        <input type="submit" name="submit" value="Add Note" />
    </form>
</div>';
}
?>
<div id="notesContainer">
    <form method="post">

        <?php
        if (isset($_SESSION['loggedIn'])){
            
            $notes = $dbHandler->fetchNotesByUser($_SESSION['loggedIn']['id']);
            
            if (count($notes) > 0 ) {
                foreach ($notes as $note) {
                    echo '<div id ="note">
                        <h4>'.$note["title"].'</h4>
                        <p>'.$note["text"].'</p>
                        <label>
                            <input type="checkbox" name="note'.$note["id"].'" value="'.$note["id"].'"> 
                            Delete
                        </label>
                        </div>';
                }
                echo '<input type="submit" name="delte" value="Delete notes" />';
            }
        }
        ?>
               
    </form>
</div>

</div>
</body>
</html>