<?php
	function db_connect_mysqli(){
		// Function to establish initial connection to the database
        	$con = mysqli_connect("127.0.0.1","root","","AssistedSpeak"); //Connection string	
		// Check connection
		if (!$con) {
    			die("Connection failed: " . mysqli_connect_error());
		} else{
			return $con;
		}
	}
	
	function db_connect_pdo() {
		try {
			$pdo = new PDO('mysql:host=127.0.0.1;dbname=AssistedSpeak','root','');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		}
		catch (PDOException $e) {
			die("Connection failed: " . $e->getMessage());
		}
	}
?>
