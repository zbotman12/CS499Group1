<html>
    <!-- File: createagent.php
         Makes an agent entry in database.
    -->
    <head> 
		<title>Create An Agent Account</title>
	</head>
    <?php 
    include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/DBTransactor/DBTransactorFactory.php";

    function getCompanyInfo(){
    
    $company=DBTransactorFactory::build("Agencies");
    $tempCond = array('company_name');
    $tempS = array();

    $company_array=$company->select($tempCond, []);
    $final_array= array();
    //var_dump($company_array);
    foreach($company_array as $key => $com)
    {
        //var_dump($com);
        array_push($final_array, $com["company_name"]);
    }

    

    return $final_array;
    }

   
    ob_start();
            var_dump($companies);
            $result_information = ob_get_clean();
            error_log($result_information,0);
    ?>
    <link
    href="/js/crayJS/jquery-ui.min.css"
    type="text/css"
    rel="stylesheet">
    <body>

        <?php 
 $companies= getCompanyInfo();
         include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; ?>
        <script type="text/javascript" src="/js/crayJS/jquery-ui.js"></script>
        <script type="text/javascript">

       $(function() {
        var availableTags =<?php echo json_encode($companies); ?>;
       $('#company_name').autocomplete({
        source: availableTags
        });
    });

                $(function() {
                var availableTags = [ "AK","AL","AR","AZ","CA","CO","CT","DE","FL","GA","HI","IA","ID","IL","IN","KS","KY","LA","MA","MD","ME","MI","MN","MO","MT","NC","ND","NE","NH","NJ","NM","NV","NY","OH","OK","OR","PA","RI","SC","SD","TN","TX","UT","VA","VT","WA","WI","WV","WY"];
                $('#state').autocomplete({
                source: availableTags,
                change: function (event, ui) {
                        if(!ui.item){
                            $('#state').val("");
                        }
                }
                });
            });
        </script>
		<div class="container-fluid">
        <h2>Create An Agent Account</h2>

        <form id="createagent" action="/Helpers/createAgentHandle.php" method="post">
            <input type='hidden' name='submitted' id='submitted' value='1'/>
            
            <legend><b class="bold">Enter company information</b></legend>
            
            <label for="company_name">Company Name:</label>
            <input class="company" type='text' name='company_name' id='company_name' maxlength='100' required/> <br/>

            <label for="address"> Company Address: </label>
            <input type='text' name='address' id='address' maxlength='100' required/><br/>

            <label for='city'> City: </label>
            <input type='text' name='city' id='city' maxlength='45' required/>
            
            <label for='state'> State: </label>
            <input class="state" type='text' name='state' id='state' maxlength='2' placeholder="Select State" required/>
            
            <label for='zip'> Zip: </label>
            <input type='text' name='zip' id='zip' maxlength='5' required/> <br/>

            <label for="agency_phone_number">Phone Number: </label>
            <input type='text' name='agency_phone_number' id='agency_phone_number' maxlength='14' placeholder="ex.123-456-7890" required/> <br/> <br/>
            
            <legend><b class='bold'> Create your agent credentials</b></legend>
            
            <label for ='user_loginname'>Username: </label>
            <input type='text' name='user_login' id='user_login' maxlength='50' required/><br/>

            <label for='password' >Create a password:</label>
            <input type='password' name='password' id='password' maxlength="25" required/> <br/>

            <label for='confirm_pass'>Confirm Password:</label>
            <input type='password' name='confirm_pass' id='confirm_pass' maxlength="25" required/><br/> <br/>

            <legend><b class='bold'>Enter your agent information</b></legend>
            
            <label for='first_name'> First name: </label>
            <input type="text" name="first_name" id='first_name' maxlength="50" required/> <br/>

            <label for='last_name'> Last name: </label>
            <input type="text" name="last_name" id='last_name' maxlength="50" required/><br/>

            <label for='email'> Email: </label>
            <input type='text' name='email' id='email' maxlength="255" required/><br/>

            <label for='agent_phone_number'> Phone number:</label>
            <input type='text' name='agent_phone_number' id='agent_phone_number' maxlength="14" required/><br/>

            <input type='submit' name='Submit' value='Submit' /> <br/>
        </form>
		</div>

        <?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
    </body>    
</html>
