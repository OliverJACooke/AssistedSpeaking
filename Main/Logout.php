<?php
	setcookie("LoggedIn", "", time() - 3600);
	header("Location: ../Main/Default.php");
?>