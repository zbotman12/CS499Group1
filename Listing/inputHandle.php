<?php
session_start();
connectAndSend();
header('location: photoUpload.php');

exit;



function connectAndSend()
{
	$DB_LOCATION = 'localhost:8889';  //Server URL
	$DB_USERNAME = 'root';//'nick';       //Database access username use 'root' for testing
								 //nick is our username
	$DB_PW       = 'root';//diliberti';  //Database access password use 'root' for testing
							// diliberti is our password
	$DB_NAME     = 'test';//'ParagonMLS';    //Name of database to be accessed use 'test' for testing

	$conn = new mysqli($DB_LOCATION, $DB_USERNAME, $DB_PW, $DB_NAME);

	if ($conn->connect_error) {
		//echo "Connection failed: " . $conn->connect_error;
	} else {
		//echo "Connection successful<br/>";
	}

	// define variables and set to empty values
	$price = $desc = $address = $footage = $roomDesc = $localDesc =
	$alarm = $agency = $agent = $city = $state = $zip = $num_bathrooms = 
	$num_bedrooms = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$price = test_input($_POST["price"]);
		$desc = test_input($_POST["desc"]);
		$address = test_input($_POST["address"]);
		$footage = test_input($_POST["footage"]);
		$roomDesc = test_input($_POST["roomDesc"]);
		$localDesc = test_input($_POST["localDesc"]);
		$alarm = test_input($_POST["alarm"]);
		$agency = test_input($_POST["agency"]);
		$agent = test_input($_POST["agent"]);
		$city = test_input($_POST["city"]);
		$state = test_input($_POST["state"]);
		$zip = test_input($_POST["zip"]);
		$num_bathrooms = test_input($_POST["num_bathrooms"]);
		$num_bedrooms = test_input($_POST["num_bedrooms"]);
	}

	$sql = "INSERT INTO Listings(price, city,
	state, zip, address, square_footage, number_of_bedrooms, number_of_bathrooms,
	room_desc, listing_desc, additional_info) 
	VALUES ('$price', '$city', '$state', '$zip', 
	'$address', '$footage', '$num_bedrooms', '$num_bathrooms', '$roomDes', '$desc', '$localDesc')";

	if (mysqli_query($conn, $sql)) {
		//echo "New record created successfully";
		//$sql = "SELECT MAX(MLS_number) FROM Listings
		//WHERE Agents_listing_agent_id = agent_id";
		$_SESSION['temp_MLS'] = 1;//mysqli_query($comm, $sql);
	} else {
		//echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>
