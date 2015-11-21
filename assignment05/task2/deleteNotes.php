<?php
// DELETE NOTES

if (isset($_POST['submitDelete']) && isset($_POST['delete'])) {
    $notesToDelete = array();
    foreach($_POST['delete'] as $noteId){
        $notesToDelete[] = $noteId;
    }

    if($dbHandler->deleteNotes($notesToDelete)) {
        $response = array("status" => "OK", "message" =>"Successfully deleted notes.";
    }
    else {
        $response = array("status" => "ERROR", "message" => "Sorry, we couldn't delete those notes.";
    }
}
else {
	$response = array("status" => "ERROR", "message" => "missingParameter"); 
}

header("Content-type: application/json"); 
echo json_encode($response);
?>