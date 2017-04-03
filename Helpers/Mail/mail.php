<?php

    /* mail.php
       Functions to send mail.
    */

    include "../DBTransactor/DBTransactorFactory.php";

    class Mail {

        //Send email function for add Showing.
        // Throws exception. Make sure to catch the exception.
        public function send_mail($showing) {

            //Create transactors
            $agentsTable   = DBTransactorFactory::build("Agents");
            $agencyTable   = DBTransactorFactory::build("Agencies");
            $listingsTable = DBTransactorFactory::build("Listings");

            //Arrays of the listing, agent, and agency info to email.
            $listing = null;
            $agent   = null;
            $agency  = null;
            
            // Get listing information
            $sel = ['Agents_listing_agent_id', 'address', 'city', 'state', 'zip'];
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
            
            // Check if we actually got something.
            if (empty($result)) {
                throw new Exception("Could not fetch agent info. Contact system administrator.");
            }

            // Set agent array
            foreach ($result as $array) {
                $agent = $array;
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

            // Create Email message
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
                                      href=\"207.98.161.214\" target=\"_blank\">
                                      ParagonMLS</a></p>" . "
                            </body>
                        </html>";

            // To send HTML mail, the Content-type header must be set
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            $headers[] = "To:" . " " . $agent['first_name'] . " " . $agent['last_name'] . " " . "<" . $agent['email'] . ">";
            $headers[] = 'From: ParagonMLS <postmaster@ParagonMLS.com>';

            // Return either true or false if email was sent.
            return mail($to, $subject, $message, implode("\r\n", $headers));
        }

        // Cron job mail. 
        public function cron_mail() {

            // Create transactors
            $agentsTable   = DBTransactorFactory::build("Agents");
            $listingsTable = DBTransactorFactory::build("Listings");

            // Get id, first name, last name, and email of ALL agents.
            $sel = ['agent_id', 'first_name', 'last_name', 'email'];
            $result = $agentsTable->select($sel, []);

            // Get ALL listings. Get the agent emails.

            // Organize 
        }

        // Send email through email form.
        public function email_form($messageArray) {
            
            // Create transactors
            $agentsTable   = DBTransactorFactory::build("Agents");
            
            // Get Agent information
            $sel = ['first_name', 'last_name', 'email'];
            $result = $agentsTable->select($sel, ["agent_id" => $messageArray['showing_agent_id']]);
            
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
                                  href=\"207.98.161.214\" target=\"_blank\">
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
    }

?>
