<html>

<head>
	<title>Task 17</title>
</head>

<body>
	<h2>Donald Bradman : The greatest batsman</h2>
	<hr> </hr>

	<?php
		//Get the info
		$score = $_POST['score'];
		$country = $_POST['country'];
		$save = $_POST['save'];

		//Open the file to be read and then close it
		$file = fopen("info.txt", "r");
		$string = fread($file,filesize("info.txt"));
		$lines = explode(PHP_EOL, $string);
		fclose($file);

		//Initial settings
		$Total = 0;
		$Count = 0;
		$Result = array();

		echo "<p>Innings against $country with scores greater than $score :</p>";
		
		//Extract the info
		for ($i=0; $i < count($lines); $i++) {
			$Innings = explode(":", $lines[$i]);
			$Num = trim($Innings[0], " ");
			$Opposition = trim($Innings[1], " ");
			$Dismissal = trim($Innings[2], " ");
			$Runs = trim($Innings[3], " ");
			
			//Use the Country and Score to filter the Info
			if ($Runs >= $score) {
				if ($country == "All"){
					$Total = $Total + floatval($Runs);
					$Count = $Count + 1;
					if ($Dismissal == "Not Out"){
						$Count = $Count - 1;
						$Text = "$Runs was scored against $Opposition and he was $Dismissal";
						echo "<li>$Text</li>";
						array_push($Result, $Text);
					} else {
						if ($Dismissal == "Retired"){
							$Count = $Count - 1;
							$Text = "$Runs was scored against $Opposition and he $Dismissal hurt";
							echo "<li>$Text</li>";
							array_push($Result, $Text);
						} else {
							$Text = "$Runs was scored against $Opposition and he was out $Dismissal";	
							echo "<li>$Text</li>";
							array_push($Result, $Text);
						}
					}
				} else {
					if($Opposition == $country){
						$Total = $Total + floatval($Runs);
						$Count = $Count + 1;
						if ($Dismissal == "Not Out"){
							$Count = $Count - 1;
							$Text = "$Runs and he was $Dismissal";
							echo "<li>$Text</li>";
							array_push($Result, $Text);
						} else {
							if ($Dismissal == "Retired"){
								$Count = $Count - 1;
								$Text = "$Runs and he $Dismissal hurt";
								echo "<li>$Text</li>";
								array_push($Result, $Text);
							} else {
								$Text = "$Runs and he was out $Dismissal";
								echo "<li>$Text</li>";
								array_push($Result, $Text);
							}
						}
					}
				}
			}
		}

		//Calculate the Average and display the results
		$Average = round($Total/$Count,2);
		echo "<p>A total of $Total runs was scored at an average of $Average</p>";

		//Save the results to text file
		if ($save == "yes") {
			echo "<br>";
			echo "The results was saved at " .date("H:i:s", filemtime("Results.txt"));
			$file = fopen("Results.txt", "w");
			fwrite($file, "Innings against $country with scores greater than $score :".PHP_EOL);
			fwrite($file, "".PHP_EOL);

			for ($i=0; $i < count($Result); $i++) {
				fwrite($file, $Result[$i].PHP_EOL);
			}
			
			fwrite($file, "".PHP_EOL);
			fwrite($file, "A total of $Total runs was scored at an average of $Average");
			fclose($file);
		} else {
			echo "<p>The results was not saved</p>";
		}

	?>

</body>
</html>