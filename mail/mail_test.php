<?php

    // Mail test.
    include "mail.php";

    echo "Hello world <br>";      
    
    $array = Array( "Listings_MLS_number"   => 6,
                    "start_time"            => "9:00am",
                    "end_time"              => "10:00am",
                    "is_house_vacant"       => true,
                    "customer_first_name"   => "James",
                    "customer_last_name"    => "Bond",
                    "lockbox_code"          => "123",
                    "showing_agent_id"      => 3 );

    //Sending email
    echo "Sending test email to agent <br>";

    if (send_mail($array)) {
    	echo "Email send succesfully! <br>";
    } else {
    	echo "Email was not sent";
    }
?>
