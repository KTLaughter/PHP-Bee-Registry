<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html lang="en">
	<head>
		<title>Saints Hope Farm Beehive Documentation - Kolby Laughter</title> 
		<meta http-equiv="content-type"content="text/html; charset=iso-8859-1" /> 
		<link href="beeRegistryLaughter.css" rel="stylesheet"/> <!--link to css code so the page can look a little nicer-->
		<h1 style ="text-align:center">Saints Hope Farm Beehive Documentation</h1>
	</head>
	<body> 
	
	<form  style = "text-align:center" action="beeRegistryLaughter.html">
		<button type="button" onclick="history.back();" >Go Back</button> <!--A button that lets the user go back if there was an error without losing their input-->
		<button type="submit" name="NewEntry">Create New Entry</button> <!-- A button that lets the user create a new entry -->
	</form>


	<?php

	$DBConnect = new mysqli('localhost', 'root', ''); 

	if ($DBConnect->connect_error) 
	{
		die("Database has not been created yet");
	}
	
	$DBSearch = $DBConnect->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'BeeRegistry'"); //sql code to check if the database has been created yet
	
	if ($DBSearch->num_rows > 0) {
		$DBConnect = mysqli_connect('localhost', 'root', '', 'BeeRegistry'); 
	} 
	else 
	{
		echo "<p>The database has not been created yet (try adding an entry to the database first)</p>";//print to the user that they haven't created the database yet
		exit;
	}
	
	//this segment creates a nice table for the data to be viewed in
		$SQLstring = "SELECT * FROM BeeTable"; 
		
		$Show = mysqli_query($DBConnect, $SQLstring);
		
	if (mysqli_num_rows($Show) > 0) {

		echo "<table class='DisplayTable'>";//create html table and its header rows
		echo "<tr><th>Keeper Name</th>";
		echo "<th>Date Of Inspection</th>";
		echo "<th>Greenhouse Number</th>";
		echo "<th>Clean And Organized</th>";
		echo "<th>Hive Stage</th>";
		echo "<th>Problems With Hive</th></tr>";
		
		while ($Line = mysqli_fetch_assoc($Show)) {//create a new row for the input
			echo "<tr>";
			echo "<td>" . $Line["Name"] . "</td>";
			echo "<td>" . $Line["Date"] . "</td>";
			echo "<td>" . $Line["GreenHouse"] . "</td>";
			echo "<td>" . $Line["Choice"] . "</td>";
			echo "<td>" . $Line["HiveLevel"] . "</td>";
			echo "<td>" . $Line["Problem"] . "</td>";
			echo "</tr>";
		}
		
		echo "</table>";
	} 
	else 
	{
		echo "<p>0 results</p>";
	}
	
	mysqli_close($DBConnect);
	?>
	</body>
</html>