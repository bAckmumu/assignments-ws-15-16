<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task 2: Sffuhle my Wrods!</title>
</head>
<body>
	<h1>
		Sffuhle my Wrods! (Result)
	</h1>
	<h2>
		<?php
			$shuffleinput = $_REQUEST['shuffleinput']; 
	 		function shuffleText($text){
			  	
			  	$words = explode(" ", $text);
			  	
			  	for ($i=0; $i < count($words); $i++) { 
			  		$word = $words[i];

			  		if (strlen($word) < 4 ) {
			  			continue;
			  		}

			  		$words[i] = shuffleWord($word);
			  	}

			  	return implode(" ",$words);
			};

			function shuffleWord($word){
				$rest = substr($word, 2, -1);
				shuffle($rest);

				return $word[0] . $rest . $word[count($word - 1)];
			};

			echo "fib($shuffleinput) = ";
			echo shuffleText($shuffleinput);
			echo "<br>";
    	?>
    	<br>
    	<a href="fibonacci2a.html">New computation</a>
	</h2>
</body>
</html>