
<?php
    /*
    File: editAgentAccountHandle.php
    editListingDisplay data handler. Updates listing based on MLS number.
    Throws exception if MLS number is not in the database. 
    */


    include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/DBTransactor/DBTransactorFactory.php";

    $agents = DBTransactorFactory::build("Agents");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {

            //Remove trailing spaces
            $_POST['user_login'] = str_replace(' ', '', $_POST['user_login']);
           
            // Update the agent.
            $agents->update($_POST, ["user_login" => $_POST['user_login']]);
            
            header("Location: ../listings.php");
        } catch(Exception $e) {
            echo $e->getMessage() . "<br\>";
        }
        
    }
?>
