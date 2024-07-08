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
	
	<form style = "text-align:center" action="showBeeRegistry.php" method="post"><!--Seperate form for the viewing of the file contents feature  (managed by a different script)-->
        <button type="submit" name="showContents">Show File Contents</button>
	</form>
	
	
	<?php
	//assigning the input to appropriate variables
	$Name = $_POST['Name'];
	$Date = $_POST['Date'];
	$GreenHouse = $_POST['GreenHouse'];
	$Choice = $_POST['Choice'];
	$HiveLevel = $_POST['HiveLevel'];
	$Problem = $_POST['Problem'];
	?>
	
	
	<?php
	//function to check if the names were submitted properly and ensures the name is made with alphabetical characters (it removes non-letters)
	function NameCheck(&$data){
		if (empty($data)){
		echo "<p style=text-align:center>Please ensure the name has been entered properly</p>\n";
		exit;
		}
		else{
			$data = preg_replace('/[^A-Za-z ]+/', '', strtolower($data));
			return $data;
		}
	}
	?>
	
	
	   <?php
	//function to check if the date was submitted or left blank. If left blank, halt the program and send an error message
	function DateCheck(&$data){
		if (empty($data)){
		echo "<p style=text-align:center>Please ensure the date has been entered properly</p>\n";
		exit;
		}
		else{
			return $data;
		}
	}
	?>
	
	
	   <?php
	//function to check if the user entered any problems or comments for the hive. If they didn't, the code writes "none" to the variable so the DB will be more readable
	function ProblemCheck(&$data){
		if (empty($data)){
		echo "<p style=text-align:center>No problems with that hive!</p>\n";
		$data = "None";
		}
		else{
			return $data;
		}
	}
	?>
	
	
	<?php
	//this segment of code invokes the functions that validate the input and passes the variables through them
	NameCheck($Name);
	DateCheck($Date);
	ProblemCheck($Problem);
	?>
	
	
	<?php
	//this code segment creates an instance of mysqli, with the defualt host name and passwords for xammp, and then connects and creates the database
	$Host = 'localhost'; 
	$User = 'root'; 
	$Password = ''; 
	$DB = 'BeeRegistry';
	
	$DBConnect = new mysqli($Host, $User, $Password); //I used mysqli instead as the method shown in the book is deprecated
	
	if ($DBConnect === FALSE)//error message if the connection fails. there are many of these throughout this program
		echo "<p>Could not connect to the database " . mysqli_connect_error() . "</p>\n";//
	
	$SQLstring = "CREATE DATABASE IF NOT EXISTS $DB";//again, the method is a bit different from the (mysql_create_db()) method in the book
	
	if (!mysqli_query($DBConnect, $SQLstring)) {
		echo "<p>Error creating database: </p>" . mysqli_error($DBConnect);
	}
	
	$DBConnect = mysqli_connect($Host, $User, $Password, $DB); //open the connection to the server

	if ($DBConnect === FALSE) {
		die("Could not connect to the database " . mysqli_connect_error());
	}
	
	?>
	
	
	<?php
	//this segment selects the database and then creates the table that the data is to be stored in 
	$Result = mysqli_select_db($DBConnect, $DB); 
	if ($Result === FALSE) //select the database so that the table is not added to the wrong one
		echo "<p>Database could not be selected .</p>" . "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>";
	
	//I have to check if the table exists first because if not, an error will prevent the rest of the code from executing
	$SQLstring = "CREATE TABLE IF NOT EXISTS BeeTable (
		Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		Name VARCHAR(50),
		Date DATE,
		GreenHouse VARCHAR(2),
		Choice CHAR,
		HiveLevel INT,
		Problem TEXT)";

	if (!mysqli_query($DBConnect, $SQLstring)) {//these statements check for errors and execute the statement at the same time
		echo "<p>Could not create the table " . mysqli_error($DBConnect) . "</p>";
	} 
	?>
	
	
	<?php
	// this segment adds the data into the database and prints an error to the user if it goes wrong
	$SQLstring = "INSERT INTO BeeTable (Name, Date, GreenHouse, Choice, HiveLevel, Problem) VALUES ('$Name', '$Date', '$GreenHouse', '$Choice', '$HiveLevel', '$Problem')";
	
	if (!mysqli_query($DBConnect, $SQLstring)) {
		echo "<p>Could not insert data into database " . $SQLstring . "<br>" . mysqli_error($DBConnect) . "</p>";
	} 
	
	mysqli_close($DBConnect);
	?>
	
	
	</body>
</html>