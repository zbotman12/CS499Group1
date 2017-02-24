<!--
    File: DB_Agents.php
    Class to create Agent database transactions in ParagonMLS database.
    
    When implementing a DBTransactor in your files, the transactor will initiate a
    connection to the ParagonMLS database.
    
    Once you are done with the object, you do not have to call the destructor implicitly.
    PHP calls it at the end of the script.

-->

<?php

    class DB_Agents extends Paragon implements DBTransactor {
        
        // ***************************************************************************
        // Private fields    
        private $AGENTS_TABLE;
        private $AGENCIES_TABLE = 'Agencies';
        private $connection;    

        // ****************************************************************************
        // Constructor/Desctructor and Public Methods

        // Initializes a connection to the ParagonMLS database.
        // Given a table name. Creates a database connection to the table.
        public function __construct($TABLE_NAME) {
            $this->AGENTS_TABLE = $TABLE_NAME;
            $this->connection = parent::getConn();

            //Check for connection errors
            if ($this->connection->connect_error) {
                throw new Exception("Connection failed: " . $this->connection->connect_error);
            } 
        }

        // Destroys object and closes database connection
        public function __destruct() {
            //echo "Closing connection! Goodbye! <br/>";
            $this->connection->close();
        }

        // ***************************************************************************
        // DBTransactor Methods (To be implemented)
        
        /** insert()
        *  DB_Agents also creates an agency if agency supplied doesn't exist as agent depends on agency existence.
        *  @throws Exception, BadMethodCallException
        */
        public function insert($assoc_array) : bool {

            //Quarantine Zone
            try {
                $assoc_array = q_zone($assoc_array);
            }
            catch(Exception $e) {
                throw $e;
            }
            catch (BadMethodCallException $e) {
                throw $e;
            }

            //Build query to check existence of Agency  
            $query  = "SELECT * FROM " . $this->AGENCIES_TABLE . " ";
            $query .= "WHERE company_name = \"" . $assoc_array['company_name'] . "\" ";
            
            //Query the database
            $agency_results = $this->connection->query($query);
            $agency_exists = false;

            //Check if agency exists. TODO: Remove echo statements. Throw exceptions.
            if ($agency_results) {
                if ($agency_results->num_rows == 1) {
                    //echo "Agency exists <br/>";
                    $agency_exists = true;  
                } else {
                    //echo "Agency doesn't exist<br/>";
                    $agency_exists = false;
                }
            } else { // Something happened. Could not create agent.
                throw new Exception($this->connection->error);
            }

            if ($agency_exists) { //Agency exists. Get its agency ID. Create agent and assign agency ID obtained. 
                
                //Build query to select agency id
                $query  = "SELECT agency_id FROM " . $this->AGENCIES_TABLE . " WHERE company_name=" . "'" . $assoc_array['company_name'] . "'" .";";

                //Fetch row of agency_id
                $r = $this->connection->query($query);
                $row = $r->fetch_assoc();
                
                //Build insert agent query
                $agent_query = "INSERT INTO " . $this->AGENTS_TABLE . " VALUES (NULL,";
                $agent_query .= "'" . $row['agency_id']                 . "'" . ",";
                $agent_query .= "'" . $assoc_array['user_login']          . "'" . ",";
                $agent_query .= "'" . $assoc_array['password']          . "'" . ",";
                $agent_query .= "'" . $assoc_array['first_name']         . "'" . ",";
                $agent_query .= "'" . $assoc_array['last_name']          . "'" . ",";
                $agent_query .= "'" . $assoc_array['email']              . "'" . ",";
                $agent_query .= "'" . $assoc_array['agent_phone_number'] . "'" . ");";
                
                //echo $agent_query . "<br/>";
                
                //IMPORTANT
                //Check if agent already exists in database!
                $dup_query = "SELECT * FROM " . $this->AGENTS_TABLE . " WHERE user_login=" . "'" . $assoc_array['user_login'] . "';";    
                $dup_results = $this->connection->query($dup_query);

                if ($dup_results) {
                  if ($dup_results->num_rows == 1) {
                      throw new Exception("Username already exists!<br/> Cannot create agent.");
                  } 
                } else {
                    throw new Exception($this->connection->error);
                }

                //Query the database. Insert Agent into Agents table
                $results = $this->connection->query($agent_query);
                
                //Check results. $results is either true or false
                if($results) {
                    return true;
                } else {
                    throw new Exception("Could not create agent! Database error! " . $this->connection->error);
                    //echo $this->connection->error;
                    //return false;
                }
            } else { //Agency doesn't exist. Create a new agency. After creating agency. Give agency ID to agent. 
                
                //Build agency query 
                $agency_q = "INSERT INTO " . $this->AGENCIES_TABLE   . " VALUES (NULL,";
                $agency_q .= "'" . $assoc_array['company_name']         . "'" . ",";
                $agency_q .= "'" . $assoc_array['agency_phone_number']  . "'" . ",";
                $agency_q .= "'" . $assoc_array['city']                 . "'" . ",";
                $agency_q .= "'" . $assoc_array['state']                . "'" . ",";
                $agency_q .= "'" . $assoc_array['zip']                  . "'" . ",";
                $agency_q .= "'" . $assoc_array['address']              . "'" . ");";
                
                //echo $agency_q . "<br/>";
                
                //Insert agency into database
                $result = $this->connection->query($agency_q);

                //Check results of insertion
                if ($result) { 
                    echo "Created Agency Successfully! <br/>";
                    echo "Creating agent... <br/>";
                    
                    //Check if agent username is in database. Ensures unique usernames.
                    $dup_query = "SELECT * FROM " . $this->AGENTS_TABLE . " WHERE user_login=" . "'" . $assoc_array['user_login'] . "';";            
                    $dup_results = $this->connection->query($dup_query);

                    if ($dup_results) {
                      if ($dup_results->num_rows == 1) {
                          throw new Exception("Username already exists!<br/> Cannot create agent.");
                          //$conn->close();
                          //return false;
                      } 
                    } else {
                        throw new Exception($this->connection->error);
                        //return false;
                    }

                    //Build agent entry as username is unique
                    $query = "SELECT agency_id FROM " . $this->AGENCIES_TABLE . " WHERE company_name=" . "'" . $assoc_array['company_name'] . "'" .";";
                    $r = $this->connection->query($query);
                    $row = $r->fetch_assoc();

                    //echo $row['agency_id'] . "<br/>";

                    //Build insert agent query
                    $agent_query = "INSERT INTO " . $this->AGENTS_TABLE. " VALUES (NULL,";
                    $agent_query .= "'" . $row['agency_id']                 . "'" . ",";
                    $agent_query .= "'" . $assoc_array['user_login']          . "'" . ",";
                    $agent_query .= "'" . $assoc_array['password']          . "'" . ",";
                    $agent_query .= "'" . $assoc_array['first_name']         . "'" . ",";
                    $agent_query .= "'" . $assoc_array['last_name']          . "'" . ",";
                    $agent_query .= "'" . $assoc_array['email']              . "'" . ",";
                    $agent_query .= "'" . $assoc_array['agent_phone_number'] . "'" . ");";
                    //echo $agent_query . "<br/>";

                    //Insert agent into database
                    $results = $this->connection->query($agent_query);
                    
                    //Check if agent was added succesfully
                    if($results) {
                        //echo "Created agent successfully!<br/>";
                        return true;
                    } else {
                        throw new Exception("Could not create agent! Database error!"); 
                        //return false;
                    }
                } else {
                    throw new Exception("Could not create Agency! Could not create agent credentials! Database error!");
                    //return false;
                }
            }
        }

        /* insertAgent()
        * This function already assumes agent knows his agency ID and creates an
        * agent entry in Agents table. agency_id must be in the map.
        * Returns true if successful completion. 
        * Otherwise, throws exception due to mysql.
        * @throws Exception, BadMethodCallException
        */
        public function insertAgent($assoc_array) {

            //Quarantine Zone
            try {
                $assoc_array = q_zone($assoc_array);
            }
            catch(Exception $e) {
                throw $e;
            }
            catch (BadMethodCallException $e) {
                throw $e;
            }

            $agent_query = "INSERT INTO " . $this->AGENTS_TABLE. " VALUES (NULL,";
            $agent_query .= "'" . $assoc_array['agency_id']                 . "'" . ",";
            $agent_query .= "'" . $assoc_array['user_login']          . "'" . ",";
            $agent_query .= "'" . $assoc_array['password']          . "'" . ",";
            $agent_query .= "'" . $assoc_array['first_name']         . "'" . ",";
            $agent_query .= "'" . $assoc_array['last_name']          . "'" . ",";
            $agent_query .= "'" . $assoc_array['email']              . "'" . ",";
            $agent_query .= "'" . $assoc_array['agent_phone_number'] . "'" . ");";

            $dup_query = "SELECT * FROM " . $this->AGENTS_TABLE . " WHERE user_login=" . "'" . $assoc_array['user_login'] . "';";    
            $dup_results = $this->connection->query($dup_query);

            if ($dup_results) {
              if ($dup_results->num_rows == 1) {
                  throw new Exception("Username already exists! Cannot create agent.");
              } 
            } else {
                throw new Exception($this->connection->error);
            }

            //Query the database. Insert Agent into Agents table
            $results = $this->connection->query($agent_query);
            
            //Check results. $results is either true or false
            if($results) {
                return true;
            } else {
                throw new Exception("Could not create agent! Database error! " . $this->connection->error);
                //echo $this->connection->error;
                //return false;
            }
        }

        // update() -> Updates Agent information in database 
        public function update($set_array, $where_array) : bool {return false;}
        public function delete($key_array)               : bool {return false;}
        public function select($array)                   : array   {return array();}
        
        // Search function for agent does not have to be implemented for this object.
        // Return a search function
        public function search($assoc_rray)              : array   {return array();}


        // ***************************************************************************
        // Private Methods

        /** Quarantine zone.
        *    Makes sure everything about the Agent associative array is ok
        */
        private function q_zone($assoc_array) {
            // Sanitize the associative array. 
            $assoc_array = array_map(array($this,"sanitizer"), $assoc_array);

            // Check for empty fields. 
            if($this->hasEmptyFields($assoc_array)) {
                throw new BadMethodCallException ("Fields cannot be empty!");
            } 

            //Check if passwords match
            if (strcmp($assoc_array['password'], $assoc_array['confirm_pass']) != 0) {
                throw new BadMethodCallException ("Could not create agent. Passwords do not match!");
            }

            return $assoc_array;
        }
        
        /* hasEmptyFields()
        *  Given an associative array with strings as values, determines if any of the values are empty
        *  Returns bool
        */
        private function hasEmptyFields($arr) 
        {
            foreach($arr as $k => $v) 
            {
                if (empty($v)) {
                  //echo "$k cannot be empty </br>";
                  return true;
                }
            }
            return false;
        }

        /* sanitizer() 
        *  Given a string, strips special characters and slashes
        */
        private function sanitizer($data) {
           return htmlspecialchars(stripslashes(trim($data))); 
        }
    }

?>
