<?php
	function log_out(){
		setcookie("LoggedIn", "", time() - 3600);
		header("Location: ../Main/Default.php");
	}
?>