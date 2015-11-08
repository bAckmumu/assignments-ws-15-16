
<!--
	Task 2: Codebreaker
-->
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
$letterErr = "";
$gameOver ="";
$letter0 = $letter1 = $letter2 = $letter3 = "";
$letters = array("A","B","C","D","E","F","G");

if( isset($_SESSION['guesses'])) {
	if( count($_SESSION['guesses']) > 10 ) { 
		session_destroy();
		$_SESSION = array();

		$gameOver ="GAME OVER!";
	}
}

if(!isset($_SESSION['secretCode'])){
	$_SESSION['secretCode'] = initSecretCode(); 
}

if(!isset($_SESSION['guesses'])){
	$_SESSION['guesses'] = array(); 
}

 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$temp = test_input($_POST["letter0"]);

	$guessedCode = str_split( strtoupper( substr($temp, 0, 4) ) );

	$_SESSION['guesses'][] = $guessedCode;

	//if (empty($_POST["letter0"]) 
   	//|| empty($_POST["letter1"]) 
   	//|| empty($_POST["letter2"]) 
   	//|| empty($_POST["letter3"]) ) {
   	//	$letterErr = "All four text fields need one letter as input";
	//} else {
    //	$letter0 = test_input($_POST["letter0"]);
    //	// check if letter0 only contains letters and whitespace
    //	if (!preg_match("/^[a-zA-Z ]*$/",$letter0)) {
    //		$firstnameErr = "Only letters and white space allowed"; 
    //	}
   	//}
      
 }

function initSecretCode() {
	$secretCode = array("A","B","C","D");

	return $secretCode;
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

function getTrs() {
	$tr = "";

	foreach ($_SESSION['guesses'] as $value) {
		$tr = $tr . "<tr>" . getTd($value) . "</tr>";
	}

	return $tr;
}

function getTd($data) {
	$td = "";

	foreach ($data as $value) {
		$td = $td."<td>".$value."</td>";
	}

	$colors = checkGuessedCode($data);
	foreach ($colors as $value) {
		$td = $td."<td>".$value."</td>";
	}

	return $td;
}

function checkGuessedCode($data) {
	$red = '<img src="images/red.jpg" alt="letters is part of the code and also at the correct position" height="32" width="32">';
	$black = '<img src="images/black.jpg" alt="letters is part of the code but not at the correct position" height="32" width="32">';
	$white = '<img src="images/white.jpg" alt="letter is not part of the code" height="32" width="32">';

	$colors = array();
	for ($i=0; $i < 4; $i++) { 
		for ($j=0; $j < 4; $j++) { 
			if ($data[i] == $_SESSION['secretCode'][j] && i == j) {
				$colors[i] = $red;
				break;
			}
			elseif ($data[i] == $_SESSION['secretCode'][j] && i != j) {
				$colors[i] = $black;
				break;
			}
			else {
				$colors[i] = $white;
			}
		}
	}

	return $colors;

function debugInfo() {
	$rows = '';
	foreach ($_SESSION['guesses'] as $value) {
		$rows = $rows . ' | ' . implode(' ', $value);
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
	</form>
	<br>
	<span class="error"><?php echo $letterErr;?></span>
	<br><br>
	<h1 class="error"><?php echo $gameOver;?></h1>
	<br><br>
	<table>
		<?php echo getTrs(); ?>		
	</table>
	<p class="error" >	Debug: <?php echo debugInfo();?></p>
</body>
</html>
