<!-- 
    File: createagenttest.php
    Makes an agent and agency entry in database.    
-->

<!-- PHP code -->
<?php
    
    // Include a factory whenever you need a database connection.
    include './DBTransactor/DBTransactorFactory.php';

    function createAgent() {

        //Create information associative array to supply to 
        $info = array( 
                    "company_name"         => $_POST['company_name'],
                    "address"              => $_POST['company_address'], 
                    "city"                 => $_POST['company_city'], 
                    "state"                => $_POST['company_state'], 
                    "zip"                  => $_POST['company_zip'], 
                    "agency_phone_number"  => $_POST['company_phone_number'],
                    "user_login"           => $_POST['username'],
                    "password"             => $_POST['password'],
                    "confirm_pass"         => $_POST['confirmPass'],
                    "first_name"           => $_POST['firstname'],
                    "last_name"            => $_POST['lastname'],
                    "email"                => $_POST['email'],
                    "agent_phone_number"   => $_POST['agent_phone_number']);

        // Create a connection to the database and access Agents table
        $agent = DBTransactorFactory::build("Agents");

        // Insert Agent information into database.
        try {
            if($agent->insert($info) == true) {
                echo "Created your account succesfully! You may now login.";
            }
            else {
                echo "Could not create agent credentials. <br/>";
            }
        }
        catch(Exception $e) {
            //PHP Code to Handle Database Exception
        }
        catch(BadMethodCallException $e) {
            //PHP Code to Handle $e bad user input Exception
        }
    }
?>

<body>
    <?php createAgent(); ?>
    <a href="./logintest.php">Login</a><br/>
</body>

