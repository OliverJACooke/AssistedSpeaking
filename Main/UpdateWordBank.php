<?php

	function db_connect(){
		// Function to establish initial connection to the database
        	$con = mysqli_connect("188.121.44.165","AssistedSpeak","a55!sT3D","AssistedSpeak"); //Connection string	
		// Check connection
		if (!$con) {
    			die("Connection failed: " . mysqli_connect_error());
		} else{
			return $con;
		}
	}

	function create_new_category($con, $image, $category){
		// Function to create a new category
		$sql = "INSERT INTO WordGroup
				(GroupName,
				Image)
					VALUES (
				'".$category."', 
				'../Images/WordImages/".$image.".png')";

		// Attempt new category creation
		run_sql_query($con, $sql);

	}

	function run_sql_query($con, $sql){
		// Function to run the provided SQL query
		if (mysqli_query($con, $sql)) {
    			//echo "New record created successfully";
		} else {
    			echo "Error: " . $sql . "<br>" . mysqli_error($con);
		}
		//mysqli_close($con);
	}

	function get_category_id($con, $image, $category){
		// Function to get the category id corresponding to the category name
		$sql = "SELECT GroupID from WordGroup WHERE GroupName = '" . $category . "'";

		// Run query and fetch category id if category exists
		$result = $con->query($sql);
		if ($result->num_rows > 0){
			$row = $result->fetch_assoc();
			$category_id = $row["GroupID"];
			return $category_id;
		// Otherwise Create the category and get the id
		} else {
			create_new_category($con, $image, $category);
			$category_id = get_category_id($con, $image, $category);
			return $category_id;
		}
	}

	//////////// MAIN CODE START ////////////

	// Call db connection
	$con = db_connect();
			
	if(isset($_POST['submit'])) {
		$word = $_POST['word'];
		$phrase = $_POST['phrase'];
		$action = $_POST['action'];

		// Check if an image was provided and set image variable if so
		if ($_POST['image'] != "") {
			$image = $_POST['image'];
		// Otherwise set to the default image
		} else {
			$image = "noImage";
		}
	

		// Check if a category was provided and add word to an existing group if so
		if ($_POST['category'] != "") {
			$category = $_POST['category'];
		
		
			// If category is not the Core category, get ID
			if (strtolower($category) != "core") {
				$category_id = get_category_id($con, $image, $category);
			// Otherwise set category ID to 0
			} else {
				$category_id = 0;
			}

			// If user specified a category and selected "add"
			if ($action == "add" && $word != "") {

				$sql = "INSERT INTO Words 
						(GroupID,
						PhraseName,
						Phrase,
						Image)
					VALUES (
						'".$category_id."',
						'".$word."', 
						'".$phrase."',
						'../Images/WordImages/".$image.".png')";


				// Call query function
				run_sql_query($con, $sql);
			
			// If user specified a category and selected "delete"
			} elseif ($action == "delete") {

				// Check if a word was also provided, and only delete the specified word if so
				if ($word != "") {
					$sql = "DELETE FROM Words WHERE PhraseName = '".$word."' and GroupID = '".$category_id."'";

					// Run Query
					run_sql_query($con, $sql);

				// Otherwise delete category and all words
				} else {
					$sql_words_delete = "DELETE FROM Words WHERE GroupID = '".$category_id."'";
					$sql_category_delete = "DELETE FROM WordGroup WHERE GroupID = '".$category_id."'";

					// Run delete queries
					run_sql_query($con, $sql_words_delete);
					run_sql_query($con, $sql_category_delete);
					}


				}


	
		}
			
		mysqli_close($con);
		
	}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Words</title>
</head>
    
<body>
</br>
	<a href="../Main/Default.php">Back to AssistedSpeaking</a>
        <form action="../Main/WordUpload.php" method="post">
		<h1>Action</h1>
		<p> Specify the desired action.</p>
		<input type="radio" name="action" value="add" checked>Add<br>
		<input type="radio" name="action" value="delete">Delete<br><br><hr><hr>
		<h1>Category</h1>
		<p>Specify the category to select. Entering "Core" will select the core words category. If the selected category does not exist then it will be created.</p>
        	<input type="text" name="category" id="category"/>
        	<h1>Word</h1>
        	<p>Specify a word to add to the selected category. This word will be appear under the newly created button</p>
        	<input type="text" name="word" id="word"/>
        	<h1></h1>
        	<h1>Phrase</h1>
        	<p>Enter the phrase to be spoken when the word is selected</p>
        	<input type="text" name="phrase" id="phrase"/>
			<h1>Image Name</h1>
			<p>Image name, with no spaces. If no value is provided then the image will default to a cross symbol.</p>
        	<input type="text" name="image" id="image"/>
        	</br></br>
        	<input type="submit" name="submit" value="submit">
        </form>
</body>
</html>