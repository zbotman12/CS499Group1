<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/goodAgents.php";
    //include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
	header('location: ./../../Showing Schedule/agentShowings.php');
	//include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/DBTransactor/DBTransactorFactory.php";
	$showings = DBTransactorFactory::build("Showings");
    $ShowingsArray = $showings->delete(['showing_id' => $_GET['showing_id']]);
?>
