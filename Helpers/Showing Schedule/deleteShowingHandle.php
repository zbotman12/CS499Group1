<?php
	header('location: ./../../Showing Schedule/showings.php?MLS=' . $_GET['MLS']);
	include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/DBTransactor/DBTransactorFactory.php";
	$showings = DBTransactorFactory::build("Showings");
    $ShowingsArray = $showings->delete(['showing_id' => $_GET['showing_id']]);
?>