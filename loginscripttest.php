<?php
	
$DB_LOCATION = 'localhost';  //Server URL
$DB_USERNAME = 'nick';       //Database access username
$DB_PW       = 'diliberti';  //Database access password
$DB_NAME     = 'example';    //Name of database to be accessed

$conn = new mysqli($DB_LOCATION, $DB_USERNAME, $DB_PW, $DB_NAME);

if ($conn->connect_error) {
	echo "Connection failed: " . $conn->connect_error;
} else {
	echo "Connection successful<br/>";
}
 
if ($result = $conn->query("SELECT * FROM nicktest")) {
    while ($row = $result->fetch_array()){
		echo $row["name"] . " " . $row["value"];
		echo "<br />";
	}
} else {
	echo $conn->error;
}

echo "<br/>";	
$conn->close();
echo "End of content";
?>