<?php 
	//On every single page where you will require knowledge about the session, you must call session_start() to resume that session
	session_start();
	if(!isset($_SESSION))
	{
		unset($_SESSION);
		session_destroy();
		header("Location:logintest.php");
		exit();
	}
?>