
<!-- Task 2: Codebreaker -->
<?php session_start(); ?>

<!DOCTYPE HTML> 
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Task 3: Create a reliable, usable, secure contact form</title>
	<style>
	.error {color: #FF0000;}
	</style>
</head>

<?php
// define variables and set to empty values
//$letterErr = "";
//$gameOver ="";
$letter0 = "";
$letters = array("A","B","C","D","E","F","G");

// destroy session when game lost or won
if( isset($_SESSION['gameover'])) {
	session_destroy();
	$_SESSION = array();
}

if(!isset($_SESSION['colors'])){
	$_SESSION['colors'] = array( "red" => 0, "black" => 1, "white" => 2 ); 
}

if(!isset($_SESSION['secretCode'])){
	$_SESSION['secretCode'] = initSecretCode(); 
}

if(!isset($_SESSION['guesses'])){
	$_SESSION['guesses'] = array(); 
}

// process post 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$guessedCode = getPostInput();	

	$colors = checkGuessedCode( $guessedCode );

	// add newest guesse to session
	$_SESSION['guesses'][$guessedCode] = $colors;
	
	checkIsGameOver();

	checkIsGameWon($colors);
 }


function getPostInput() {
	$guessedCode = testInput($_POST["letter0"]);

	while ( strlen($guessedCode) < 4) {
		$guessedCode = $guessedCode."?";
	}

	$guessedCode = substr($guessedCode, 0, 4);

	$guessedCode = strtoupper( $guessedCode );

	return $guessedCode;	
}

function checkGuessedCode($guessedCode) {
	$data = str_split($guessedCode);

	$colors = array();
	for ($i=0; $i < 4; $i++) { 
		for ($j=0; $j < 4; $j++) { 
			if ($data[$i] == $_SESSION['secretCode'][$j] && $i == $j) {
				$colors[$i] = $_SESSION["colors"]["red"];
				break;
			}
			elseif ($data[$i] == $_SESSION['secretCode'][$j] && $i != $j) {
				$colors[$i] = $_SESSION["colors"]["black"];
				break;
			}
			else {
				$colors[$i] = $_SESSION["colors"]["white"];
			}
		}
	}

	return $colors;
}

function buildTrsHtml() {
	$tr = "";

	foreach ($_SESSION['guesses'] as $key => $value) {
		$tr = $tr . "<tr>" . buildTdHtml($key, $value) . "</tr>";
	}

	return $tr;
}

function buildTdHtml($guesse, $colors) {
	$redHtml = '<img src="images/red.jpg" alt="letters is part of the code and also at the correct position" height="32" width="32">';
	$blackHtml = '<img src="images/black.jpg" alt="letters is part of the code but not at the correct position" height="32" width="32">';
	$whiteHtml = '<img src="images/white.jpg" alt="letter is not part of the code" height="32" width="32">';

	$td = "";

	foreach (str_split($guesse) as $value) {
		$td = $td."<td>".$value."</td>";
	}

	foreach ($colors as $value) {
		$html;
		
		if ($value ==  $_SESSION["colors"]["red"] ) {
			$html = $redHtml;
		}
		elseif ($value == $_SESSION["colors"]["black"] ) {
			$html = $blackHtml;
		}
		else {
			$html = $whiteHtml;
		}

		$td = $td."<td>".$html."</td>";
	}

	return $td;
}

function initSecretCode() {
	// todo generate random code  
	$secretCode = array("A","B","C","D");

	return $secretCode;
}

function testInput($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

function checkIsGameOver() {
	if( count($_SESSION['guesses']) >= 10 ) { 
		$_SESSION['gameover'] = "GAME OVER!";
	}
}

function checkIsGameWon($colors) {
	$isWon = true;
	
	foreach ($colors as $value) {
		if ( $value != $_SESSION["colors"]["red"] ) {
			$isWon = false;
		}
	}

	if ($isWon) {
		$_SESSION['gameover'] = "You broke the code and won the game!";
	}
}

function debugInfo() {
	$rows = "";
	foreach ($_SESSION["guesses"] as $key => $value) {
		$rows = $rows ." | Key: ". $key ." Value: ";

		foreach ($value as $temp) {
			$rows = $rows . $temp;
		}

	}

	return $rows;	
}

?>

<body> 
	<h2>Task 2: Codebreaker</h2>
	<p>
		Codebreaker is a game where the player has to guess a four-letter code. The code is formed of a random combination of the letters A, B, C, D, E, F, or G. Every letter can only appear once in it. The player enters his or her guess into a form and receives a hint until they found out the code. The hint has the following semantics:
		<ul>
			<li>A red dot indicates that one of the guessed letters is part of the code and also at the correct position.</li>
			<li>A black dot indicates that one of the guessed letters is part of the code but not at the correct position</li>
			<li>A white dot indicates that a letter is not part of the code.</li>
		</ul>
	</p>
	
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" > 
		<input type="text" name="letter0" value="<?php echo $letter0;?>">
		<!--<input type="text" name="letter1" value="<?php echo $letter1;?>">
		<input type="text" name="letter2" value="<?php echo $letter2;?>">
		<input type="text" name="letter3" value="<?php echo $letter3;?>">-->
		<input type="submit" name="submit" value="Submit">
		<!--<span class="error"><?php echo $letterErr;?></span>-->
	</form>

	<?php 
	if (isset($_SESSION['gameover'])) {
		echo '<h1 class="error">'. $_SESSION['gameover'] .'</h1>';
	}
	?>
	
	<br>
	<table>
		<?php echo buildTrsHtml(); ?>		
	</table>
	
	<!-- uncommand to get debug infos -->
	<!--<br><br>
	<p class="error" >	Debug: <br> 
	<?php
		echo "Guesse count: ". count($_SESSION['guesses']) ."<br>";
		echo "Guesses: ". debugInfo();
	?>
	</p>-->
</body>
</html>
