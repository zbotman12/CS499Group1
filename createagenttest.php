<!-- 
    File: createagenttest.php
    Makes an agent and agency entry in database.    
-->

<!-- PHP code -->
<?php
    
    // Include a factory whenever you need a database connection.
    include './DBTransactor/DBTransactorFactory.php';

    function createAgent() {
        //Test
        print_r($_POST);
        
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
    <?php createAgent(); ?>
    <a href="./logintest.php">Login</a><br/>
</body>
