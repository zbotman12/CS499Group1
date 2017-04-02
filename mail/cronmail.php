<?php

	// This is the php cron mailer.
	// This script will email every user with a listing every day with the view count of the listings.
	// Make cron excecute this script at your desired time. 
	
	include "mail.php";

	$mailer = new Mail;

	$mailer->cron_mail();
?>

