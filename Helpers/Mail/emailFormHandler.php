<?php

	include "mail.php";

	$mailer = new Mail;

    if ($mailer->email_form($_POST)) {
    	echo "Email sent succesfully! <br>";
    } else {
    	echo "Email was not sent";
    }
	/*
	<html>
		<!--Files--> 
		<link href="../../style/bootstrap.min.css" rel="stylesheet">
	    <link href="../../style/bootstrap.css" rel="stylesheet">
	    <script src="../../js/jquery-1.11.3.js"></script>
	    <script src="../../js/bootstrap.min.js"></script>
		<div class="alert alert-success alert-dismissable">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  <strong>Email sent!</strong> We've sent your email over to the recipient.
		</div>
	</html>
	*/
?>

