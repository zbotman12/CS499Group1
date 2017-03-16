<?php
include "./../sessioncheck.php";
include "./../dbconnect.php";

// define variables and set to empty values
$price = $desc = $address = $footage = $roomDesc = $localDesc =
$alarm = $agency = $agent = $city = $state = $zip = $num_bathrooms = 
$num_bedrooms = "";

//clean and set all the inputs
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$price = test_input($_POST["price"]);
	$desc = test_input($_POST["desc"]);
	$address = test_input($_POST["address"]);
	$footage = test_input($_POST["footage"]);
	$roomDesc = test_input($_POST["roomDesc"]);
	$localDesc = test_input($_POST["localDesc"]);
	$alarm = test_input($_POST["alarm"]);
	$city = test_input($_POST["city"]);
	$state = test_input($_POST["state"]);
	$zip = test_input($_POST["zip"]);
	$num_bathrooms = test_input($_POST["num_bathrooms"]);
	$num_bedrooms = test_input($_POST["num_bedrooms"]);
}

//Get the listing agent id from the session
$agent = $_SESSION["name"];
$agent_id = mysqli_query($conn, "SELECT agent_id FROM Agents WHERE user_login='$agent'")->fetch_array()["agent_id"];
echo mysqli_error($conn);

if(!($agent_id = mysqli_query($conn, "SELECT agent_id FROM Agents WHERE user_login='$agent'")->fetch_array()["agent_id"]))
{
	echo "Error: <br>" . mysqli_error($conn);
}

//Check if this house is already in the database.
if(!empty(mysqli_query($conn, "SELECT MLS_number FROM Listings WHERE address='$address' AND state='$state' AND zip='$zip' AND Agents_listing_agent_id='$agent_id'")->fetch_array()))
{
	echo "House already listed. <br>";
	//Go ahead with the current listed house and move on to pictures page
	$mls = $result->fetch_array()["MLS_number"];
	$_SESSION['temp_MLS'] = $mls;//mysqli_query($comm, $sql);
	header('location: photoUpload.php');
	exit;
}

//Query to put a new house into the database
$sql = "INSERT INTO Listings(Agents_listing_agent_id, price, city,
state, zip, address, square_footage, number_of_bedrooms, number_of_bathrooms,
room_desc, listing_desc, additional_info) 
VALUES ('$agent_id', '$price', '$city', '$state', '$zip', 
\"$address\", '$footage', '$num_bedrooms', '$num_bathrooms', \"$roomDesc\", \"$desc\", \"$localDesc\")";

if (mysqli_query($conn, $sql)) {

	echo "New record created successfully";
	//Get the new houses MLS number from the DB
	if($result = mysqli_query($conn, "SELECT MLS_number FROM Listings WHERE address='$address' AND state='$state' AND zip='$zip' AND Agents_listing_agent_id='$agent_id'"))
	{
		//Save the MLS number and move on to the pictures page
		$mls = $result->fetch_array()["MLS_number"];
		$_SESSION['temp_MLS'] = $mls;//mysqli_query($comm, $sql);
		header('location: photoUpload.php');
		exit;

	} else {
		echo "Error: <br>" . mysqli_error($conn);
	}

} else {
	echo "Error: <br>" . mysqli_error($conn);
}

//IMPORTANT NOTE (RYAN): We need to alter test_input so that we can
//Use special characters like apostrophes without causing sql errors.
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>