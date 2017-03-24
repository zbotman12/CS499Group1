<?php
	header('location: ./../showings.php?MLS=' . $_GET['MLS']);
	include "../DBTransactor/DBTransactorFactory.php";
	$showings = DBTransactorFactory::build("Showings");
    $ShowingsArray = $showings->delete(['showing_id' => $_GET['showing_id']]);
?>