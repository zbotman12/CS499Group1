<?php

    /* mail.php
       Functions to send mail.
    */
    
    include __DIR__ . "/../DBTransactor/DBTransactorFactory.php";

    class Mail {

        //Send email function for add Showing.
        // Throws exception. Make sure to catch the exception.
        public function showing_mail($showing) {
            
            // Parse config file. Get info.
            $config = $this->parseConfig();
            
            //Create transactors
            $agentsTable   = DBTransactorFactory::build("Agents");
            $agencyTable   = DBTransactorFactory::build("Agencies");
            $listingsTable = DBTransactorFactory::build("Listings");

            //Arrays of the listing, agent, and agency info to email.
            $listing = null;
            $agent   = null;
            $agency  = null;
            $showingAgent = null;

            // Get listing information
            $sel = ['Agents_listing_agent_id', 'address', 'city', 'state', 'zip'];

            //echo "Did I get called?";
            $result  = $listingsTable->select($sel, ["MLS_number" => $showing['Listings_MLS_number']]);
            
            // Check if we actually got something.
            if (empty($result)) {
                throw new Exception("Could not fetch listing. Contact system administrator.");
            }

            // Set listing array
            foreach ($result as $array) {
                $listing = $array;
            }

            // Get Agent information
            $sel = ['first_name', 'last_name', 'email', 'Agencies_agency_id'];
            $result = $agentsTable->select($sel, ["agent_id" => $listing['Agents_listing_agent_id']]);
            
            //Get showing Agent information
            $sel = ['first_name', 'last_name', 'email'];
            $showingA = $agentsTable->select($sel, ["agent_id" => $showing['showing_agent_id']]);
            
            // Check if we actually got something.
            if (empty($result || empty($showingA))) {
                throw new Exception("Could not fetch agent info. Contact system administrator.");
            }

            // Set agent array
            foreach ($result as $array) {
                $agent = $array;
            }
            
            // Set showing agent array 
            foreach ($showingA as $array) {
                $showingAgent = $array;
            }

            // Get Agency information. 
            $sel = ['company_name'];
            $result = $agencyTable->select($sel, ["agency_id" => $agent['Agencies_agency_id']]);

            // Check if we got something
            if (empty($result)) {
                throw new Exception("Could not fetch agency info. Contact system administrator.");
            }

            // Set Agency array.
            foreach ($result as $array) {
                $agency = $array;
            }

            // Create Email message for listing agent.
            $to = $agent['email'];
            $subject = "NEW SHOWING:" . " " . $listing['address'] . " " . "has a new showing.";

            $message = "<html>
                            <head>
                                <title>ParagonMLS</title>
                            </head>
                            <body>
                                <p> Dear" . " " . $agent['first_name'] . " " . $agent['last_name'] . " <br>" . "
                                <p> Your listing at the following address has a new showing available: </p><br>" . $listing['address'] . "<br>" . $listing['city'] . "," . $listing['state'] . " " . $listing['zip'] . "</p>" . 
                                "<p> <table>
                                          <tr>
                                            <th>Customer Name</th> 
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Lockbox Code </th>
                                          </tr>
                                          <tr>
                                            <td>" . $showing['customer_first_name'] . " " . $showing['customer_last_name'] . "</td>
                                            <td>" . $showing['start_time'] . "</td>
                                            <td>" . $showing['end_time'] . "</td>
                                            <td>" . $showing['lockbox_code'] . "</td></tr>
                                      </table>" . "<br> <p> This is an automated
                                      email from ParagonMLS. <br> CS499 Team 1. <a
                                      href=\"" . $config['websiteURL'] . "\" target=\"_blank\">
                                      ParagonMLS</a></p>" . "</body></html>";

            // To send HTML mail, the Content-type header must be set
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            $headers[] = "To:" . " " . $agent['first_name'] . " " . $agent['last_name'] . " " . "<" . $agent['email'] . ">";
            $headers[] = 'From: ParagonMLS <postmaster@ParagonMLS.com>';

            //Create email message for showing agent.
            $toS = $showingAgent['email'];

            $showingASubject = "You've been schedule for a showing.";

            $showingMessage  = "<html><head><title> ParagonMLS</title></head> <body> <p> Dear " . $showingAgent['first_name'] . " " . $showingAgent['last_name'] . "</p><br>";
            $showingMessage .= "<p> You've been scheduled for a showing at the following address </p><br>" . $listing['address'] . "<br>" . $listing['city'] . "," . $listing['state'] . " " . $listing['zip'] . "</p>" .
                                "<p><table>
                                          <tr>
                                            <th>Customer Name</th> 
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Lockbox Code </th>
                                          </tr>
                                          <tr>
                                            <td>" . $showing['customer_first_name'] . " " . $showing['customer_last_name'] . "</td>
                                            <td>" . $showing['start_time'] . "</td>
                                            <td>" . $showing['end_time'] . "</td>
                                            <td>" . $showing['lockbox_code'] . "</td></tr>
                                      </table>" . "<br> <p> This is an automated
                                      email from ParagonMLS. <br> CS499 Team 1. <a
                                      href=\"" . $config['websiteURL'] . "\" target=\"_blank\">
                                      ParagonMLS</a></p>" . "
                            </body>
                        </html>";

            // Return either true or false if both emails were sent.
            return (mail($to, $subject, $message, implode("\r\n", $headers))) && (mail($toS, $showingASubject, $showingMessage, implode("\r\n", $headers)));
        }

        // Cron job mail. 
        public function cron_mail() {

            // Create listing transactor
            $listingsTable = DBTransactorFactory::build("Listings");

            // Get all listings info with the following selection
            $sel = ["MLS_number", "Agents_listing_agent_id", "address", "city", "state", "zip", "daily_hit_count", "hit_count"];
            $allListings = $listingsTable->select($sel, []);

            // Initialize mailList
            $agent_id = null;
            $mls      = null;
            $mailList = [[]];

            //Iterate through the entire database and create a mailList.
            foreach ($allListings as $MLSarr) {
                //Set current agent ID. 
                $agent_id = $MLSarr['Agents_listing_agent_id'];

                //Check if we have key in mailList
                if (array_key_exists($agent_id, $mailList)) {
                    $mailList[$agent_id][] = $MLSarr;
                } else { //Key not in maillist, create new entry for agent.
                    $mailList[$agent_id][] = $MLSarr;
                }
            }

            // SPAM
            array_map(array($this, 'mass_mailer'), $mailList);

            //Reset daily hit count for all listings after mass mailer.
            $mlsNumbers = array_keys($allListings);

            foreach($mlsNumbers as $m) {
                $listingsTable->resetDailyHitCron($m);
            }
        }

        private function mass_mailer($agentListings) {
            // Parse config file. Get info.
            $config = $this->parseConfig();

            //Build transactors
            $agentsTable   = DBTransactorFactory::build("Agents");
            $agent_id = null;

            //Return empty list if current agent has no listings. Do not mail anything.
            if (empty($agentListings)) {
                return [];
            }
            
            //Get agent id.
            $agent_id = $agentListings[0]['Agents_listing_agent_id'];

            //Get agent info from db.
            $sel = ["first_name", "last_name", "email"];
            $agent = $agentsTable->select($sel, ["agent_id" => $agent_id]);
            
            $agent = $agent[$agent_id];
            //var_dump($agent);

             // Create email message. 
            $to = $agent['email'];
            $subject = "Daily Hit Count - ParagonMLS.";
            
            // Headers
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            $headers[] = "To:" . " " . $agent['first_name'] . " " . $agent['last_name'] . " " . "<" . $agent['email'] . ">";
            $headers[] = 'From: ParagonMLS <postmaster@ParagonMLS.com>';

            $messageHead = "<html><head><title>ParagonMLS</title></head>
                        <body><p> Dear" . " " . $agent['first_name'] . " " . $agent['last_name'] . " <br></p>";
            $messageHead .= "<body><p> Here are the daily hit counts for your listings.</p> <p>";
            
            $message = null;

            //Iterate through agents listings.
            //Construct message array.
            foreach($agentListings as $listing) {
                $message  = $message . "MLS Number: " . $listing['MLS_number'] . "<br>";
                $message .=  "Address:" . $listing['address'] . " " . $listing['city'] . ", " . $listing['state'] . " " . $listing['zip'] . "<br>";
                $message .= "Daily Hit Count: " . $listing['daily_hit_count'] . "<br>" . "Overall Hit Count: " . $listing['hit_count'] . "<br><br>";
            }
            
            $message = $message . "<p> This is an automated
                                  email from ParagonMLS. <br> CS499 Team 1. <a
                                  href=\"" . $config['websiteURL'] . "\" target=\"_blank\">
                                  ParagonMLS</a></p>" . "</p></body></body><html>";
            //var_dump($agentListings);
            //var_dump($message);
            //echo $messageHead . $message;

            //Send email.
            mail($to, $subject, ($messageHead . $message) , implode("\r\n", $headers));
        }

        // Send email through email form.
        public function email_form($messageArray) {
            // Parse config file. Get info.
            $config = $this->parseConfig();
            
            // Sanitize $messageArray for white space and convert to integer.
            $messageArray['MLS_number'] = intval(str_replace(' ', '', $messageArray['MLS_number']));
            //var_dump($messageArray);
            // Initialize agent array
            $agent = array();
            $listing = array();

            // Create transactors
            $agentsTable   = DBTransactorFactory::build("Agents");
            $listingsTable = DBTransactorFactory::build("Listings");

            //Get listing agents id from listings.
            $sel = ['Agents_listing_agent_id'];
            $result = $listingsTable->select($sel, ["MLS_number" => $messageArray['MLS_number']]);
            
            // Check if we actually got something.
            if (empty($result)) {
                throw new Exception("Could not fetch agent info. Contact system administrator.");
            }

            // Set agent array
            foreach ($result as $array) {
                $listing = $array;
            }

            // Get Agent information
            $sel = ['first_name', 'last_name', 'email'];
            $result = $agentsTable->select($sel, ["agent_id" => $listing['Agents_listing_agent_id']]);
            
            // Check if we actually got something.
            if (empty($result)) {
                throw new Exception("Could not fetch agent info. Contact system administrator.");
            }

            // Set agent array
            foreach ($result as $array) {
                $agent = $array;
            }

            // Create email message. 
            $to = $agent['email'];
            $subject = "You've received a message from " . $messageArray['name'] . ". ParagonMLS.";

            $message = "<html>
                            <head>
                                <title>ParagonMLS</title>
                            </head>
                            <body>
                                <p> Dear" . " " . $agent['first_name'] . " " . $agent['last_name'] . " <br>" . "
                                <p> You've received the following message from" . " " . $messageArray['name'] . ": </p><br>
                                <p> --BEGIN MESSAGE-- <br><br>" . $messageArray['message'] .  " </p>";
            $message .= "<p> --END MESSAGE --</p> <br> <p>You may reach " . $messageArray['name'] . " at the following email address: " . $messageArray['email'] ." </p> <br> <p> This is an automated
                                  email from ParagonMLS. <br> CS499 Team 1. <a
                                  href=\"" . $config['websiteURL'] . "\" target=\"_blank\">
                                  ParagonMLS</a></p>" . "
                            </body>
                        </html>";

            // Headers
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            $headers[] = "To:" . " " . $agent['first_name'] . " " . $agent['last_name'] . " " . "<" . $agent['email'] . ">";
            $headers[] = 'From: ParagonMLS <postmaster@ParagonMLS.com>';

            // Return either true or false if email was sent.
            return mail($to, $subject, $message, implode("\r\n", $headers));
        }

            // Emails the database administrator to approve your account for legitimate agents only
        public function emailAdminNewAgent($info) {
                    // Parse config file. Get info.
                    $config = $this->parseConfig();

                    $to = $config['adminEmail'];
                    $subject = "New account request.";

                    $message = "<html>
                                    <head>
                                        <title>ParagonMLS</title>
                                    </head>
                                <body>
                                    <p> New account request with following information. </p>
                                    <table>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Company Address</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Zip</th>
                                            <th>Agency Phone Number</th>
                                            <th>Username</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                        </tr>
                                        <tr>
                                            <td>" . $info['company_name'] . "</td>" .
                                           "<td>" . $info['address']      . "</td>" .
                                           "<td>" . $info['city']         . "</td>" .
                                           "<td>" . $info['state']        . "</td>" .
                                           "<td>" . $info['zip']          . "</td>" .
                                           "<td>" . $info['agency_phone_number'] . "</td>" .
                                           "<td>" . $info['user_login']   . "</td>" .
                                           "<td>" . $info['first_name']   . "</td>" .
                                           "<td>" . $info['last_name']    . "</td>" .
                                           "<td>" . $info['email']        . "</td>" .
                                           "<td>" . $info['agent_phone_number'] . "</td>" .
                                        "</tr></table>" . "<br> <p> This is an automated
                                  email from ParagonMLS. <br> CS499 Team 1. <a
                                  href=\"" . $config['websiteURL'] . "\"  target=\"_blank\">
                                  ParagonMLS</a></p>" . "</body></html>";

                    // Headers
                    $headers[] = 'MIME-Version: 1.0';
                    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
                    $headers[] = "To:" . " " . $config['firstName'] . " " . $config['lastName'] . " " . "<" . $config['adminEmail'] . ">";
                    $headers[] = 'From: ParagonMLS <postmaster@ParagonMLS.com>';

                // Return either true or false if email was sent.
                return mail($to, $subject, $message, implode("\r\n", $headers));
            }

            private function parseConfig() {
                $filepaths = array('/var/www/config.ini','D:\wamp64\www\config.ini', 'C:\wamp64\www\config.ini', $_SERVER['DOCUMENT_ROOT'] . "/config.ini");
                $config = null;
                foreach ($filepaths as $k => $v) {
                    if(file_exists($v))
                    {
                        $config = parse_ini_file($v);
                        break;
                    }
                }
                if($config == null)
                {
                    echo "No configuration file found. Could not connect to database.";
                    exit;
                }
                return $config;
            }
    }

?>
