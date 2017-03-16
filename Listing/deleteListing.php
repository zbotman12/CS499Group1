<!--
    File: deleteListing.php
	Deletes the agents from database just given the MLS number.
-->

<?php
	include "../sessioncheck.php";
	include "../DBTransactor/DBTransactorFactory.php";

	deleteListing();

	function deleteListing() {
		$listings = DBTransactorFactory::build("Listings");
		
		//(Michael) :: Must update this to have MLS number from current session after clicking delete listing from agent session
		try {
			$listings->delete(["MLS_number" => $_POST['MLS_number']]);
		} catch (Exception $e) {
			echo $e->getMessage() . "<br/>";
		}
	}
?>