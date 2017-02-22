<!-- 
    File: dbconnect.php
    Include this file in your functions that require a database connection.
    *NOTE* you must call $conn->close(); when you finish your database operations.
-->
<?php
        $DB_LOCATION = 'localhost';  //Server URL
        $DB_USERNAME = 'root';       //Database access username
        $DB_PW       = '';           //Database access password
        $DB_NAME     = 'ParagonMLS'; //Name of database to be accessed
        $TABLE_NAME  = 'Agents';     //Name of the table to be accessed
        
        // Connect to DB
        $conn = new mysqli($DB_LOCATION, $DB_USERNAME, $DB_PW, $DB_NAME);
        
        if ($conn->connect_error) {
	       echo "Connection failed: " . $conn->connect_error;
	} else {
	       //echo "Connection successful<br/>";
	}
?>
