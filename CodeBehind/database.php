<?php
	function db_connect_mysqli(){
		// Function to establish initial connection to the database
        	//$con = mysqli_connect("188.121.44.165","AssistedSpeak","a55!sT3D","AssistedSpeak"); //Connection string	
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
			$pdo = new PDO('mysql:host=188.121.44.165;dbname=AssistedSpeak','AssistedSpeak','a55!sT3D');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		}
		catch (PDOException $e) {
			die("Connection failed: " . $e->getMessage());
		}
	}
?>
