<?php
session_start();
require_once('DBHandler.php');
require_once('AuthHandler.php');
require_once('connectionInfo.private.php');
$dbHandler = new DBHandler($host, $user, $password, $db);
$authHandler = new AuthHandler($dbHandler);

// load notes for loged in user
if ($authHandler->isUserLoggedIn()) {
	$notes = $dbHandler->getNotesForUser($authHandler->getUserId());
        
    $response = array("status" => "OK", "message" => "Successfully added note!", "notes" => array());
    foreach ($notes as $note) {
        //echo "<div class='note flexChild'><input type='checkbox' value='$note->id' name='delete[]'><div class='title'>$note->title</div><div class='content'>$note->content</div></div>";
        
        array_push($response["notes"], array( "ïd" => $note->id, "title" => $note->title, "content" => $note->content));
    }
}
else {
	$response = array("status" => "ERROR", "message" => "Not loged in!"); 
}

header('Content-Type: application/json');
echo json_encode($response);
?>