<?php
    /*
        File createagenttest.php
        Makes an agent and agency entry in database.
    */
    // Include a factory whenever you need a database connection.
    //include './DBTransactor/DBTransactorFactory.php';

    function createAgent() {

        include './DBTransactor/DBTransactorFactory.php';

        //Test
        //print_r($_POST);
        if ($_POST == Array() || empty($_POST)) {
            header("location: index.php");
            //echo "test";
            exit;
        }

        // Create a connection to the database and access Agents table
        try {
          $agent = DBTransactorFactory::build("Agents");
        }
        catch (Exception $e) {
              // Serious error. Could not connect to the database and initalize DBTransactor object.
              echo $e->getMessage() . "<br/>"; 
        }

        // Insert Agent information into database.
        try {
            if($agent->insert($_POST) == true) {
                echo "Created your account succesfully! You may now login. <br/>";
            }
            else {
                echo "Could not create agent credentials. <br/>";
            }
        }
        catch(Exception $e) {
            //PHP Code to Handle Database Exception
            echo $e->getMessage() . "<br/>";
        }
        catch(BadMethodCallException $e) {
            //PHP Code to Handle $e bad user input Exception
            echo $e->getMessage() . "<br/>";
        }
    }
?>

<body>
        <?php  include $_SERVER['DOCUMENT_ROOT'] . "/header.php" ?>
	<div class="container-fluid">
		<h2>Agent Creation</h2>
		<hr/>
		<?php
			ob_start();
			createAgent(); 
		?>
	</div>
        <?php  include $_SERVER['DOCUMENT_ROOT'] . "/footer.php" ?>
</body>