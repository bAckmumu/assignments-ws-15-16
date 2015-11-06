
<!--
	Task 3: Create a reliable, usable, secure contact form
	based on: http://www.w3schools.com/php/php_form_complete.asp
-->

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
$firstnameErr = $lastnameErr = $emailErr = $passwordErr = $subjectErr = "";
$firstname = $lastname = $email = $password = $confirmpassword = $subject = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["firstname"])) {
     $firstnameErr = "First name is required";
   } else {
     $firstname = test_input($_POST["firstname"]);
     // check if firstname only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
       $firstnameErr = "Only letters and white space allowed"; 
     }
   }
   
   if (empty($_POST["lastname"])) {
     $lastnameErr = "Last name is required";
   } else {
     $lastname = test_input($_POST["lastname"]);
     // check if lastname only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
       $lastnameErr = "Only letters and white space allowed"; 
     }
   }

   if (empty($_POST["email"])) {
     $emailErr = "Email is required";
   } else {
     $email = test_input($_POST["email"]);
     // check if e-mail address is well-formed
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $emailErr = "Invalid email format"; 
     }
   }
   
   if (empty($_POST["password"]) || empty($_POST["confirmpassword"]) ) {
     $passwordErr = "Password is required";
   } else {
     $password = test_password($_POST["password"]);
     $confirmpassword = test_password($_POST["confirmpassword"]);
     
     // check password length
     if ( strlen($password) < 16 ) {
       $passwordErr = "Your password should be at least 16 characters long"; 
     }

     // compare password and confirmpassword
     if ( !$password === $confirmpassword ) {
     	$passwordErr = "Passwords do not match";
     }
   }

   if (empty($_POST["subject"])) {
     $subjectErr = "Subject is required";
   } else {
     $subject = test_input($_POST["subject"]);
   }

   if (empty($_POST["message"])) {
     $message = "";
   } else {
     $message = test_input($_POST["message"]);
   }
 }

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

function test_password(&$data) {
   $data = htmlspecialchars($data);
   return $data;
}

?>

<body> 
	<h2>Task 3: Create a reliable, usable, secure contact form</h2>
	<p><span class="error">* required field.</span></p>
	
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
	   
		First name: <input type="text" name="firstname" value="<?php echo $firstname;?>">
		<span class="error">* <?php echo $firstnameErr;?></span>
		<br>
		Last name: <input type="text" name="lastname" value="<?php echo $lastname;?>">
		<span class="error">* <?php echo $lastnameErr;?></span>
		<br><br>

		E-mail: <input type="text" name="email" value="<?php echo $email;?>">
		<span class="error">* <?php echo $emailErr;?></span>
		<br><br>

		Password: <input type="password" name="password" value="<?php echo $password;?>">
		<span class="error">* <?php echo $passwordErr;?></span>
		<br>
		Password confirmation: <input type="password" name="confirmpassword" value="<?php echo $confirmpassword;?>">
		<span class="error">*</span>
		<br><br>

		Subject:
		<input type="radio" name="subject" <?php if (isset($subject) && $subject=="criticism") echo "checked";?>  value="criticism">Criticism
		<input type="radio" name="subject" <?php if (isset($subject) && $subject=="praise") echo "checked";?>  value="praise">Praise
		<input type="radio" name="subject" <?php if (isset($subject) && $subject=="other") echo "checked";?>  value="other">Other
		<span class="error">* <?php echo $subjectErr;?></span>
		<br><br>
		
		Message: <textarea name="message" rows="5" cols="40"><?php echo $message;?></textarea>
		<br><br>
		
		<input type="submit" name="submit" value="Submit"> 
	</form>

<?php
echo "<h2>Your Input:</h2>";
echo $firstname;
echo "<br>";
echo $lastname;
echo "<br>";
echo $email;
echo "<br>";
echo $subject;
echo "<br>";
echo $message;
?>

</body>
</html>