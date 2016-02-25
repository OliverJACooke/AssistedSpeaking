<?php
			
	$con=mysqli_connect("188.121.44.165","AssistedSpeak","a55!sT3D","AssistedSpeak");
	// Check connection
	if (!$con) {
    	die("Connection failed: " . mysqli_connect_error());
	}
	
	if(isset($_POST['submit'])) {
	
		$word = $_POST['word'];
		$phrase = $_POST['phrase'];
		
		$sql = "INSERT INTO Word 
						(Word,
						Phrase)
					VALUES (
						'".$word."', 
						'".$phrase."')";
						
			
			if (mysqli_query($con, $sql)) {
    			echo "New record created successfully";
			} else {
    			echo "Error: " . $sql . "<br>" . mysqli_error($con);
			}
			mysqli_close($con);
	}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Words</title>
</head>
    
<body>
</br>n
	<a href="../Main/Default.php">Back to AssistedSpeaking</a>
        <form action="../Main/WordUpload.php" method="post">
        	<h1>Word</h1>
        	<p>This is the word that will be displayed within the buttons</p>
        	<input type="text" name="word" id="word"/>
        	<h1>Phrase</h1>
        	<p>This is the sentence that will be read by the systems</p>
        	<input type="text" name="phrase" id="phrase"/>
        	</br></br>
        	<i>All I will say is be gentle...</i>
        	<input type="submit" name="submit" value="submit">
        </form>
</body>
</html>
