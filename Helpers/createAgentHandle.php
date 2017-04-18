<?php
    /*
        File createagenttest.php
        Makes an agent and agency entry in database.
    */
    // Include a factory whenever you need a database connection.
    //include './DBTransactor/DBTransactorFactory.php';

    function createAgent() {

        include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/Mail/mail.php";

        if ($_POST == Array() || empty($_POST)) {
            header("location: index.php");
            //echo "test";
            exit;
        }

        // We will instead email the database administrator about the new agent. 
        $mailer = new Mail;
        if($mailer->emailAdminNewAgent($_POST) == true) {
            echo "We have sent your information to the system administrator. Please wait for approval. You will receive an email from the administrator in 2-4 business days. <br/>";
        }
        else {
            echo "Could not send these credentials to system administrator. Please contact administrator directly or try again later. <br/>";
        }        

        // Create a connection to the database and access Agents table and Agencies table
        /*try {
          $agent    = DBTransactorFactory::build("Agents");
          $agencies = DBTransactorFactory::build("Agencies");

          $sel = ["address", "city", "state", "zip", "phone_number"];
          $results = $agencies->select($sel, ["company_name" => $_POST["company_name"]]);

          $agencyRes = [];

          //If results are empty, that means this is a new Agency. Take post array and upload.
          if (empty($results)) {
            if($agent->insert($_POST) == true) {
                echo "Created your account succesfully! You may now login. <br/>";
            }
            else {
                echo "Could not create agent credentials. <br/>";
            }           
          } else {
                //Agency exists. Ignore user input address and replace with database address.
                foreach ($results as $agenc) {
                    $agencyRes = $agenc;
                }

                //Replace post array values for address of listing.
                $_POST["address"]             = $agencyRes["address"];
                $_POST["state"]               = $agencyRes["state"];
                $_POST["city"]                = $agencyRes["city"];
                $_POST["zip"]                 = $agencyRes["zip"];
                $_POST["agency_phone_number"] = $agencyRes["phone_number"];

                //echo "Got in else<br>";
                //print_r($_POST);
                if($agent->insert($_POST) == true) {
                    echo "Created your account succesfully! You may now login. <br/>";
                }
                else {
                    echo "Could not create agent credentials. <br/>";
                }           
          }

        } catch (Exception $e) {
              // Serious error. Could not connect to the database and initalize DBTransactor object.
              echo $e->getMessage() . "<br/>"; 
        } catch(BadMethodCallException $e) {
            //PHP Code to Handle $e bad user input Exception
            echo $e->getMessage() . "<br/>";
        }*/
    }
?>

<body>
        <?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; ?>
	<div class="container-fluid">
		<h2>Agent Creation</h2>
		<hr/>
		<?php
			ob_start();
			createAgent(); 
		?>
	</div>
        <?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body>
