<?php 
	//On every single page where you will require knowledge about the session, you must call session_start() to resume that session
	if(session_id() == null)
	{
		session_start();
	}
	if(!isset($_SESSION['number']))
	{
		unset($_SESSION);
		session_destroy();
		//(RYAN) We should find a better way to do this
		header("Location:login.php");
		header("Location:../login.php");
		header("Location:../../login.php");
		exit();
	}
?>