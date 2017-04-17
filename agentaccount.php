<html> 
    <!-- File: agentaccount.php
         Makes an agent entry in database.
    -->
    <head>
		<title>Your Account</title>
	</head>
    <body>
        <?php
            include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php";
            include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/DBTransactor/DBTransactorFactory.php";
            include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
            
            $agentTable  = DBTransactorFactory::build("Agents");
            $agencyTable = DBTransactorFactory::build("Agencies");

            $agent  = null;
            $agency = null;
            //var_dump($_SESSION["name"]);            
            
            // Select this agents information.
            $sel = ['first_name', 'last_name', 'email', 'phone_number', 'user_login'];
            $result = $agentTable->select($sel, ["user_login" => $_SESSION["name"]]);
            
            //var_dump($result);
            // Check if we actually got something.
            if (empty($result)) {
                throw new Exception("Could not fetch agent info. Contact system administrator.");
            }

            // Set agent array
            foreach ($result as $array) {
                $agent = $array;
            }
            //var_dump($agent);
        ?>
		<div class="container-fluid">
			<h2>Edit your account</h2>
			<form id="createagent" action="./Helpers/editAgentAccountHandle.php" method="post">
				<input type='hidden' name='submitted' id='submitted' value='1'/>
				
				<label for='first_name'> First name: </label>
				<input type="text" name="first_name" id='first_name' maxlength="50" value="<?php echo $agent['first_name']?>"/>  <br/>

				<label for='last_name'> Last name: </label>
				<input type="text" name="last_name" id='last_name' maxlength="50" value="<?php echo $agent['last_name']?>"/><br/>

				<label for='email'> Email: </label>
				<input type='text' name='email' id='email' maxlength="255" value="<?php echo $agent['email']?>"/><br/>

				<label for='agent_phone_number'> Phone number:</label>
				<input type='text' name='phone_number' id='agent_phone_number' maxlength="14" value="<?php echo $agent['phone_number']?>"/><br/>

				<a href="./changepass.php" class="btn btn-default">Change Password</a>

				<input type="hidden" name = "user_login" value=" <?php echo $agent['user_login'];?>"><br><br>
				<input type='submit' name='Submit' value='Submit' /> <br/>
			</form>
		</div>
        <?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
    </body>    
</html>
