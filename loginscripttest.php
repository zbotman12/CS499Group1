<?php
	
include 'dbconnect.php';
   
if ($result = $conn->query("SELECT * FROM agents")) {
    while ($row = $result->fetch_array()){
        // Update this to include hash
        echo $row["user_login"] . " " . $row["password"];
		echo "<br />";
	}
} else {
	echo $conn->error;
}

echo "<br/>";	
$conn->close();
echo "End of content";
?>
