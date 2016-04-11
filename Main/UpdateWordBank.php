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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</head>
    
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="../Main/Default.php">
					<img class="img-responsive" src="../Images/YouSpeakTxtLarge.png" alt="YouSpeak Large" width="130"/>
				</a>
			</div>
			<ul class="nav navbar-nav">
				<li><a href="../Main/Default.php">Speech Screen</a></li>
				<li class="active"><a href="../Main/UpdateWordBank.php">New Words</a></li>
			</ul>
		</div>
	</nav>
	<div class="container">
	<h1>
		New Words/New Categories
	</h1>
	<p>
		<em>
		Use this page to add brand new words to a currently existing group, or create brand new categories to your account.
		</em>
	</p>
        <form role="form" action="../Main/WordUpload.php" method="post">
			<div class="form-group">
				<label for="Action">Action</label>
				<p> Specify the desired action.</p>
				<div class="radio">
					<label class="radio-inline"><input type="radio" name="action" value="add" checked>Add</input></label>
				</div>
				<div class="radio">
					<label class="radio-inline"><input type="radio" name="action" value="delete">Delete</input></label>
				</div>
			</div>
			<div class="form-group">
				<label for="Category">Category</label>
				<p>Specify the category to select. Entering "Core" will select the core words category. If the selected category does not exist then it will be created.</p>
				<input class="form-control" type="text" name="category" id="category"/>
			</div>
			<div class="form-group">
				<label for="Word">Word</label>
				<p>Specify a word to add to the selected category. This word will be appear under the newly created button</p>
				<input class="form-control" type="text" name="word" id="word"/>
			</div>
			<div class="form-group">
				<label for="Phrase">Phrase</label>
				<p>Enter the phrase to be spoken when the word is selected</p>
				<input class="form-control" type="text" name="phrase" id="phrase"/>
			</div>
			<div class="form-group">
				<label for="Image Name">Image Name</label>
				<p>Image name, with no spaces. If no value is provided then the image will default to a cross symbol.</p>
				<input class="form-control" type="text" name="image" id="image"/>
			</div>
			<input class="btn btn-default" type="submit" name="submit" value="submit">
			
        </form>
	</div>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
	<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	
</body>
</html>
