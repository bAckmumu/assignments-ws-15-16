<?php
require_once('DBHandler.php');
require_once('AuthHandler.php');
require_once('connectionInfo.private.php');
$dbHandler = new DBHandler($host, $user, $password, $db);
$authHandler = new AuthHandler($dbHandler);

// ADD NOTE
// check if the user has submitted a new note:
if (isset($_POST['title']) && isset($_POST['content'])) {
    
    if ($dbHandler->insertNote($_POST['title'], $_POST['content'], $authHandler->getUserId())) {
        $response = array("status" => "OK", "message" =>"Successfully added note!");
    } else {
        $response = array("status" => "ERROR", "message" =>"Oops! There was an error while saving your note.");
    }
} 
else {
	$response = array("status" => "ERROR", "message" => "missingParameter"); 
}

header('Content-Type: application/json');
echo json_encode($response);
?>