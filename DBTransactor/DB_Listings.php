<!--
    File: DB_Listings.php
    Class to create Listings database transactions in ParagonMLS database.
    
    When implementing a DBTransactor in your files, the transactor will initiate a
    connection to the ParagonMLS database.
    
    Once you are done with the object, you do not have to call the destructor implicitly.
    PHP calls it at the end of the script.

-->

<?php

    class DB_Listings extends Paragon implements DBTransactor {

        // ****************************************************************************
        // Constructor/Desctructor and Public Methods

        // Initializes a connection to the ParagonMLS database.
        // Given a table name. Creates a database connection to the table.
        public function __construct($TABLE_NAME) {
            $this->LISTINGS_TABLE = $TABLE_NAME;
            $this->connection = $this->getConn();
            
            //Check for connection errors
            if ($this->connection->connect_error) {
                throw new Exception("Connection failed: " . $this->connection->connect_error);
            } 
        }

        // Destroys object and closes database connection
        public function __destruct() {
            $this->connection->close();
        }

        // ***************************************************************************
        // DBTransactor Methods (needs testing)
        public function insert($assoc_array) : bool {

            //Quarantine Zone
            try {
                $assoc_array = $this->q_zone($assoc_array);
            }
            catch (BadMethodCallException $e) {
                throw $e;
            }
            //echo "Does it crash here? <br/>";
            //Check for duplicate entries
            $dup_query  = "SELECT * FROM "           . $this->LISTINGS_TABLE . " WHERE ";
            $dup_query .= "address="                 . "\"" . $assoc_array['address']                 . "\" AND ";
            $dup_query .= "state="                   . "\"" . $assoc_array['state']                   . "\" AND ";
            $dup_query .= "zip="                     . "\"" . $assoc_array['zip']                     . "\" AND ";
            $dup_query .= "Agents_listing_agent_id=" . "\"" . $assoc_array["Agents_listing_agent_id"] . "\";"; 

            $dup_results = $this->connection->query($dup_query);

            if ($dup_results) {
              if ($dup_results->num_rows == 1) {
                  throw new Exception("Listing already exists! Cannot create listing.");
              } 
            } else {
                throw new Exception($this->connection->error);
            }

            //Build listings query 
            // Last two default values are for hit counter and daily hit counter
            $listings_q  = "INSERT INTO " . $this->LISTINGS_TABLE   . " VALUES (NULL,";
            $listings_q .= "'" . $assoc_array['Agents_listing_agent_id']  . "'" . ",";
            $listings_q .= "'" . $assoc_array['price']                    . "'" . ",";
            $listings_q .= "\"" . $assoc_array['city']                     . "\"" . ",";
            $listings_q .= "\"" . $assoc_array['state']                    . "\"" . ",";
            $listings_q .= "\"" . $assoc_array['zip']                      . "\"" . ",";
            $listings_q .= "\"" . $assoc_array['address']                  . "\"" . ",";
            $listings_q .= "\"" . $assoc_array['square_footage']           . "\"" . ",";
            $listings_q .= "\"" . $assoc_array['number_of_bedrooms']       . "\"" . ",";
            $listings_q .= "\"" . $assoc_array['number_of_bathrooms']      . "\"" . ",";
            $listings_q .= "\"" . $assoc_array['room_desc']                . "\"" . ",";
            $listings_q .= "\"" . $assoc_array['listing_desc']             . "\"" . ",";
            $listings_q .= "\"" . $assoc_array['additional_info']          . "\"" . ",";
            $listings_q .= "\"" . $assoc_array['agent_only_info']          . "\"" . ", DEFAULT, DEFAULT);";
            
            //Insert listing into database
            $result = $this->connection->query($listings_q);
            //echo "Am I failing here?";
            //Check results. $results is either true or false
            if($result) {
                return true;
            } else {
                return false;
            }
        }

        public function update($set_array, $where_array) : bool {
            
            if(empty($set_array)) {
                throw new BadMethodCallException("\$set_array cannot be empty");
            }
            
            //Quarantine Zone
            try {
                $assoc_array = $this->q_zone($set_array);
            }
            catch (BadMethodCallException $e) {
                throw $e;
            }     
            
            $ignore = ['submitted', 'Submit'];
            
            $columns     = $this->conditionBuilder($set_array, ",", $ignore);
            $condition   = $this->conditionBuilder($where_array, " AND ", $ignore);
            
            $query = "UPDATE " . $this->LISTINGS_TABLE . " SET " . $columns . " WHERE " . $condition . ";";

            $results = $this->connection->query($query);

            if ($results) {
                return true;
            }
            else {
                return false;   
            }
        }

        /* delete()           -> Deletes an entry from the database
            @param $key_array -> A single valued associative array where ["column_name"] = value_to_delete; 
                                delete() corresponds to following mysql syntax: "DELETE FROM 'table_name' WHERE 'condition1' AND 'condition1' AND ...;
                                Array must not be empty.
          @throws BadMethodCallException  -> Throws mysql query failure if database query failed
        */
        public function delete($key_array) : bool {
            
            if (empty($key_array)) {
                throw new BadMethodCallException("Nothing to delete.");
            }

            $condition = $this->conditionBuilder($key_array, " AND ", []);

            $query = "DELETE FROM " . $this->LISTINGS_TABLE . " WHERE " . $condition . ";";

            $results = $this->connection->query($query);

            if ($results) {
                return true;
            }
            else {
                return false;
            }
        }

        /* select($array) -> Selects an entry and returns an associative array of values obtained.
        *  @param $array -> Regular list. Just give a list of column names to select.
        *  @param $cond  -> A map of conditions to to select based on.
        */
        public function select($array, $cond) {
            $isThere = false;
            $result_array = Array();

            // Check if $array is empty.
            if (empty($array)) {
                throw new Exception ("Nothing to select");
            }

            // Check if agent_id is in the query to be requested.
            if (in_array($this->index, $array) || $array == ['*']){
                $isThere = true;
            }
            else {
                array_push($array, $this->index);
            }

            // Make string acceptable for SQL command
            $s = implode(",", $array);

            // If condition is empty. Just select all columns given.
            if (empty($cond)) {
              $query = "SELECT " . $s . " FROM " . $this->LISTINGS_TABLE . ";"; 
              $results = $this->connection->query($query);

              $result_array = $this->resultToArray($results, $this->index);

            } else { //Else, select based on given conditions
              $c = $this->conditionBuilder($cond, " AND ", []);
              $query = "SELECT " . $s . " FROM " . $this->LISTINGS_TABLE . " WHERE " . $c . ";";
              
              $results = $this->connection->query($query);

              $result_array = $this->resultToArray($results, $this->index);
            }

            //If agent_id was supplied as value in $array, just return the array.
            if($isThere){
                return $result_array;
            } 
            else { //Otherwise, filter the arrays that have the values. 
                $noID = array();
                foreach ($result_array as $agid => $value) {
                    foreach ($value as $k => $v) {
                        if ($k == $this->index) {
                            unset($result_array[$agid][$k]);
                        }
                    }
                }
                return $result_array;
            }
        }

        //public function search($assoc_rray)              {return array();}

        // ***************************************************************************
        // Private Methods and Fields
        protected function q_zone($assoc_array){
            //Strip special tags
            $assoc_array = array_map(array($this, "sanitizer"), $assoc_array);

            // Don't Check for empty fields since fields can be empty. 
            /*if($this->hasEmptyFields($assoc_array)) {
                throw new BadMethodCallException ("Fields cannot be empty!");
            } */
            return $assoc_array; 
        }

        // Index query control 
        private $index = 'MLS_number';
    }
?>
