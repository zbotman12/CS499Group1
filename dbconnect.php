<!-- 
    File: dbconnect.php
    Include this file in your functions that require a database connection.
    *NOTE* you must call $conn->close(); when you finish your database operations.
-->
<?php
    function Connect()
    {
        //Find the first .ini file on the system from this list and use that
        $filepaths = array('/var/www/config.ini','D:\wamp64\www\config.ini');
        $config = null;
        foreach ($filepaths as $k => $v) {
            if(file_exists($v))
            {
                $config = parse_ini_file($v);
                break;
            }
        }
        if($config == null)
        {
            echo "No configuration file found. Could not connect to database.";
            return $conn;
        }
        $DB_LOCATION = $config['dblocation'];  //Server URL
        $DB_USERNAME = $config['username'];    //Database access username
        $DB_PW       = $config['password'];    //Database access password
        $DB_NAME     = $config['dbname'];      //Name of database to be accessed
        $TABLE_NAME  = 'Agents';               //Name of the table to be accessed
        
        // Connect to DB
        $conn = new mysqli($DB_LOCATION, $DB_USERNAME, $DB_PW, $DB_NAME);
            
        if ($conn->connect_error) {
    	       echo "Connection failed: " . $conn->connect_error;
    	} else {
    	       //echo "Connection successful<br/>";
    	}
        return $conn;
    }
?>
