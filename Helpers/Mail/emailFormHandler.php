<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";

	include "mail.php";

	$mailer = new Mail;
    $_POST['MLS_number'] = intval(str_replace(' ', '', $_POST['MLS_number']));

    if ($mailer->email_form($_POST)) {
    	//echo "Email sent succesfully! <br>";
        //return '<div class="alert alert-success">Thank You! I will be in touch</div>';
        header("location: sentEmailDisplay.php");
    } else {
    	//return '<div class="alert alert-danger">Sorry there was an error sending your message. Please try again later</div>';
        header("location: emailFailedDisplay.php");
    }
    
    //echo "<script> $(\"#myModal\").modal('hide')</script>";

    //header("location: sentEmailDisplay.php");
?>
