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
			  	
			  	for ($i=0; $i<count($words);$i++) { 
			  		$word = $words[$i];

			  		if (strlen($word) < 4 ) {
			  			continue;
			  		}

					//echo "$word".$i."= ";
					//echo $word;
					//echo "<br>";

			  		$words[$i] = shuffleWord($word);
			  	}

			  	return implode(" ",$words);
			};

			function shuffleWord($word){
				$rest = substr($word, 1, -1);
				
				$numbers = str_split($rest);
				//echo "$numbers= ";
				//echo $numbers;
				//echo "<br>";
				shuffle($numbers);

				return substr($word, 0, 1).implode($numbers).substr($word, -1);
			};

			echo "shuffleText($shuffleinput) = ";
			echo shuffleText($shuffleinput);
			echo "<br>";
    	?>
    	<br>
    	<a href="task2.html">New computation</a>
	</h2>
</body>
</html>