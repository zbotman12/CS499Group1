<?php

	// This is the php cron mailer.
	// This script will email every user with a listing every day with the view count of the listings.
	// Make cron excecute this script at your desired time. 
    echo "Hello I am cronmail.php!\n";

	//Change this to relative path. Paragon only needs absolute path. 
    include "/var/www/html/Helpers/Mail/mail.php";
    
    echo "I got past the include!\n";

    $mailer = new Mail;
    
    echo "Created a new mail object for you!\n";
    echo "I am running cron_mail!\n";

    $mailer->cron_mail();
    echo "I am finished!\n";
?>

