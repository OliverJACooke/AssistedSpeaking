<?php
	if(isset($_POST['LogOut'])) {
		setcookie("LoggedIn", "", time() - 3600);
		header("Location: ../Main/Default.php");
	}
	
	include '../CodeBehind/database.php';

	function create_new_category($con, $image, $category){
		// Function to create a new category
		
		// Define full image path
		$full_image_path = "../Images/WordImages/" . $image . ".png"; 

		$sql = "INSERT INTO WordGroup
				(GroupName,
				Image)
					VALUES (
				:groupname, 
				:full_image_path)";

		// Attempt new category creation
		$query = $con->prepare($sql);
		$query->execute(array(":groupname"=>$category,":full_image_path"=>$full_image_path));


	}

	function get_category_id($con, $image, $category){
		// Function to get the category id corresponding to the category name
		//$sql = "SELECT GroupID from WordGroup WHERE GroupName = '" . $category . "'";
		$sql = "SELECT GroupID from WordGroup WHERE GroupName=:groupname";

		// Run query and fetch category id if category exists
		$query = $con->prepare($sql);
		$query->execute(array(":groupname"=>$category));
		$results = $query->fetchAll();

		if ($results != False && $query->rowCount() > 0){
			$category_id = $results[0][0];
			return $category_id;
		} else {
			create_new_category($con, $image, $category);
			$category_id = get_category_id($con, $image, $category);
			return $category_id;
		}


	}

	//////////// MAIN CODE START ////////////

	// Call db connection
	//$con = db_connect_mysqli();
	$con = db_connect_pdo();
			
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

				// Define full image path
				$full_image_path = "../Images/WordImages/" . $image . ".png"; 

				$sql = "INSERT INTO Words 
						(GroupID,
						PhraseName,
						Phrase,
						Image)
					VALUES (
						:groupid,
						:phrasename, 
						:phrase,
						:full_image_path)";



				// Attempt word addition
				$query = $con->prepare($sql);
				$query->execute(array(":groupid"=>$category_id,":phrasename"=>$word,":phrase"=>$phrase,":full_image_path"=>$full_image_path));

			
			// If user specified a category and selected "delete"
			} elseif ($action == "delete") {

				// Check if a word was also provided, and only delete the specified word if so
				if ($word != "") {
					$sql = "DELETE FROM Words WHERE PhraseName =:phrasename and GroupID =:groupid";

					// Attempt word deletion
					$query = $con->prepare($sql);
					$query->execute(array(":phrasename"=>$word,":groupid"=>$category_id));


				// Otherwise delete category and all words
				} else {
					$sql_words_delete = "DELETE FROM Words WHERE GroupID =:groupid";
					$sql_category_delete = "DELETE FROM WordGroup WHERE GroupID =:groupid";

					// Run word delete query
					$query = $con->prepare($sql_words_delete);
					$query->execute(array(":groupid"=>$category_id));

					// Run category delete query
					$query = $con->prepare($sql_category_delete);
					$query->execute(array(":groupid"=>$category_id));
					}


				}


	
		}
			
	}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Update Word Bank</title>
	<link rel="stylesheet" href="../App_Themes/bootstrap.min.css">
	<script src="../Scripts/jquery-1.12.3.min.js"></script>
  	<script src="../Scripts/bootstrap.min.js"></script>
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
				<li><a href="../Main/Home.php">Home</a></li>
				<li><a href="../Main/Default.php">Application</a></li>
				
			</ul>
			<div id="navbar" class="nav navbar-nav navbar-right">
				<ul class="nav navbar-nav">
					<li><a href="../Main/Dashboard.php">Dashboard</a></li>
					<li><a href="../Main/Guides.php">Guides</a></li>
					<li class="active"><a href="../Main/UpdateWordBank.php">New Words</a></li>
					<li><a href="../Main/Contact.php">Contact</a></li>
					<li><a href="../CodeBehind/Logout.php">Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">
	<h1><b>
		New Words/New Categories
	</b></h1><hr><hr>
	<p>
		<em>
		From this page you can add or delete new words and word categories from the Word Bank.
		</em>
	</p>
        <form role="form" action="../Main/UpdateWordBank.php" method="post">
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
				<p>Specify the category to select. Entering <i>core</i> will select the core words category, and add or delete the word from the main Word Bank. If the selected category does not exist then it will be created.</p>
				<input class="form-control" type="text" name="category" id="category"/>
			</div>
			<div class="form-group">
				<label for="Word">Word</label>
				<p>Specify a word to add or delete from the selected category.</p>
				<input class="form-control" type="text" name="word" id="word"/>
			</div>
			<div class="form-group">
				<label for="Phrase">Phrase</label>
				<p>Enter the phrase to be spoken when the word is selected</p>
				<input class="form-control" type="text" name="phrase" id="phrase"/>
			</div>
			<div class="form-group">
				<label for="Image Name">Image Name</label>
				<p>Image name, with no spaces. If no value is provided, or the image can not be located, then the image will default to a cross symbol.</p>
				<input class="form-control" type="text" name="image" id="image"/>
			</div>
			<input class="btn btn-default" type="submit" name="submit" value="submit">
			
        </form>
	</div>
	
</body>
</html>
